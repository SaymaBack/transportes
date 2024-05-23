<?php

namespace App\Http\Controllers\Capitalhumano;

use App\Http\Controllers\Controller;
use App\Models\CatEmpleadosDocumentos;
use App\Models\Empleado;
use App\Models\EmpleadoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Ramsey\Uuid\Uuid;
use App\Traits\ThumbImgTrait;
use Illuminate\Support\Facades\URL;

class EmpleadoDocumentoController extends Controller
{
    use ThumbImgTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Empleado $empleado, Request $request)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se pudieron obtener documentos'], 'code' => 409];

        $validator = Validator::make($request->all(), ['modo_select' => 'required|boolean']);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{
            $modo_select = $validator->validated()['modo_select'];
            $catEmpleadoDocumentos = null;

            $catEmpleadoDocumentos = CatEmpleadosDocumentos::all()->where('activo', true);

            $documentos = $empleado->documentos;

            if ($catEmpleadoDocumentos) {
                foreach ($catEmpleadoDocumentos as $value) {
                    $doc = $documentos->where('empleado_documento_id', $value->id)->first();

                    $value->empleado_documento = null;
                    $value->documento_cargado = $doc ? true : false;

                    if ($doc && !$modo_select) {
                        $doc->extension = pathinfo($doc->path, PATHINFO_EXTENSION);
                        $doc->thumb = $this->getThumbImg($doc->path);
                        $value->empleado_documento = $doc;
                    }
                }

                $response['json']['success'] = true;
                $response['json']['message'] = 'Documentos obtenidos correctamente';
                $response['json']['data'] = $catEmpleadoDocumentos;
                $response['code'] = 200;
            }
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Empleado $empleado, Request $request)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $validator = Validator::make($request->all(), [
            'excluir' => 'required|boolean',
            'empleado_documento_id' => 'required|exists:cat_empleados_documentos,id',
            'documento' => [Rule::requiredIf(!$request->excluir), File::types(['pdf', 'jpg', 'jpeg', 'png', 'xlsx', 'docx', 'pptx']), 'nullable'],
            'expiracion' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->fails();
        } else{
            $validated = $validator->validated();

            $validated['path'] = null;
            $thumb = null;
            $update = false;

            if (!$validated['excluir']) {

                $documento_upd = $empleado->documentos->where('empleado_documento_id', $validated['empleado_documento_id'])->first();

                $file = $validated['documento'];
                $filename = Uuid::uuid1();
                $path = $file->storeAs('documentos/ch', $filename . '.' . $file->extension());
                $validated['path'] = $path;

                $thumb = $this->convertImage($path);

                if ($documento_upd && file_exists(storage_path("app/" . $path))) {
                    Storage::delete($documento_upd->path);
                    $this->deleteThumbImg($documento_upd->path);
                    $update = true;
                }
            }

            $documento = EmpleadoDocumento::updateOrCreate(
                ['empleado_id' => $empleado->id, 'empleado_documento_id' => $validated['empleado_documento_id']],
                [
                    'excluir' => $validated['excluir'],
                    'expiracion' => $validated['expiracion'],
                    'path' => $validated['path']
                ]
            );

            if ($documento) {
                //$documento->thumb = $thumb;
                $update = $update ? "actualizó" : "almacenó";


                $response['json']['success'] = true;
                $response['json']['message'] = "Se " . $update ." correctamente el registro";
                $response['json']['data'] = $documento;
                $response['code'] = 200;
            }


        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado, EmpleadoDocumento $empleadoDocumento)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $data = $empleado->documentos->where('id', $empleadoDocumento->id)->first();
        /* $data = $empleadoDocumento; */

        if ($data) {
            $response['json']['success'] = true;
            $response['json']['message'] = "Registro obtenido correctamente.";
            $response['json']['data'] = $data;
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Update the specified resource in storage.
     */
    /* public function update(Empleado $empleado, Request $request, EmpleadoDocumento $empleadoDocumento)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        return response()->json($response['json'], $response['code']);
    } */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado, EmpleadoDocumento $empleadoDocumento)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $data = $empleado->documentos->where('id', $empleadoDocumento->id)->first();
        $del = $data->delete();

        if ($del) {
            $response['json']['success'] = true;
            $response['json']['message'] = "Registro eliminado correctamente.";
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

    public function downloadDocs(Empleado $empleado, EmpleadoDocumento $documento = null, Request $request){
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se pudo descargar documento'], 'code' => 409];

        $expiration = now()->addHour();
        if ($documento === null) {
            $expiration = now()->addMinutes(15);
        }

        if ($documento !== null && $empleado->id === $documento->empleado_id) {
            $response['json']['success'] = true;
            $response['json']['data']['url'] = URL::signedRoute(
                'ch.files.download',
                ['empleado' => $empleado->id, 'documento' => $documento->id],
                $expiration
            );
            $response['json']['message'] = 'Se generó correctamente la URL de documentación para este empleado';
            $response['code'] = 200;
        } else {
            $documentos = '';

            if (isset($request->documentos)) {
                $documentos = json_decode($request->documentos);
            }

            $validator = Validator::make(['documentos' => $documentos], [
                'documentos' => 'required|array|min:1',
                'documentos.*' => 'required|numeric|exists:empleado_documentos,id'
            ]);

            if ($validator->fails()) {
                $response['json']['errors'] = $validator->errors()->toArray();
            } else{
                $response['json']['success'] = true;
                $response['json']['data']['url'] = URL::signedRoute(
                    'ch.files.download',
                    ['cliente' => $empleado->id, 'documento' => null, "documentos" => json_encode($validator->validated()['documentos'])],
                    $expiration
                );
                $response['json']['message'] = 'Se generó correctamente la URL de documentación para este empleado';
                $response['code'] = 200;
            }
        }
        return response()->json($response['json'], $response['code']);
    }
}
