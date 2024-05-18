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

class EmpleadoDocumentoController extends Controller
{
    use ThumbImgTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Empleado $empleado, Request $request)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $validator = Validator::make($request->all(), ['modo_select' => 'required|boolean']);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{
            $modo_select = $validator->validated()['modo_select'];
            $catEmpleadoDocumentos = CatEmpleadosDocumentos::all()->where('activo', true);

            $documentos = $empleado->documentos;

            foreach ($catEmpleadoDocumentos as $key => $value) {
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
            'empleado_documento_id' => 'required|exists:cat_empleado_documentos,id',
            'documento' => [Rule::requiredIf(!$request->excluir), File::types(['pdf', 'jpg', 'jpeg', 'png', 'xlsx', 'docx', 'pptx']), 'nullable'],
            'expiracion' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->fails();
        } else{
            $validated = $validator->validated();

            $validated['path'] = null;
            $thumb = null;

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

            $documento->thumb = $thumb;

            $response['json']['success'] = true;
            $response['json']['message'] = "Se almaceno correctamente el registro";
            $response['json']['data'] = $documento;
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Display the specified resource.
     */
    public function show(EmpleadoDocumento $empleadoDocumento)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Empleado $empleado, Request $request, EmpleadoDocumento $empleadoDocumento)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado, EmpleadoDocumento $empleadoDocumento)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        return response()->json($response['json'], $response['code']);
    }
}
