<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Models\CatDocumento;
use App\Models\Cliente;
use App\Models\ClienteDocumento;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\URL;
use App\Traits\ThumbImgTrait;

class ClienteDocumentoController extends Controller
{
    use ThumbImgTrait;


    public function index(Cliente $cliente, Request $request): JsonResponse{
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se obtuvieron documentos del cliente'], 'code' => 409];

        $validator = Validator::make($request->all(), [
            'modo_select' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{
            $catDocumentos = CatDocumento::select('id', 'nombre', 'require_token')
                        ->where('active',1)
                        ->get();

            $documentos = $cliente->documentos;

            if ($catDocumentos) {
                foreach ($catDocumentos as $value) {
                    $value->documento_cargado = false;

                    $value->cliente_documento = $documentos->where('documento_id', $value->id)->first();

                    if ($value->cliente_documento !== null) {
                        $value->documento_cargado = true;

                        if ($validator->validated()['modo_select']) {
                            $value->cliente_documento = null;
                        } else {
                            $value->cliente_documento->extension = pathinfo($value->cliente_documento->path, PATHINFO_EXTENSION);
                            $value->cliente_documento->thumb = $this->getThumbImg($value->cliente_documento->path);
                        }
                    }
                }

                $porcentaje_documentos = (count($documentos) * 100) / count($catDocumentos);

                $response['json']['data']['documentos'] = $catDocumentos;
                $response['json']['data']['porcentaje_documentos'] = round($porcentaje_documentos, 2);
                $response['json']['success'] = true;
                $response['json']['message'] = 'Documentos obtenidos correctamente.';
                $response['code'] = 200;
            }

        }

        return response()->json($response['json'], $response['code']);
    }

    public function show(ClienteDocumento $clienteDocumento){
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se obtuvo documento'], 'code' => 409];

        if ($clienteDocumento) {
            $response['json']['data'] = $clienteDocumento;
            $response['json']['success'] = true;
            $response['json']['message'] = 'Documento obtenido correctamente.';
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

    public function store(Cliente $cliente, Request $request){
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se pudo crear el documento'], 'code' => 409];

        $validator = Validator::make($request->all(), [
            'excluir' => 'required|boolean',
            'documento_id' => ['required','exists:cat_documentos,id'],
            'documento' => [Rule::requiredIf(!$request->excluir), File::types(['pdf', 'jpg', 'jpeg', 'gif', 'png', 'xml', 'xlsx', 'docx', 'pptx']), 'nullable'],
            'expiracion' => 'nullable|date'
        ]);

        if($validator->fails()){
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{
            $data_store = $validator->validated();

            $data_store['path'] = null;
            $thumb = null;

            if (!$data_store['excluir']) {

                $documento_upd = $cliente->documentos->where('documento_id', $data_store['documento_id'])->first();

                $file = $request->documento;
                $filename = Uuid::uuid1();
                $path = $file->storeAs('documentos/files', $filename . '.' . $file->extension());
                $data_store['path'] = $path;

                $thumb = $this->convertImage($path);

                if ($documento_upd && file_exists(storage_path("app/" . $path))) {
                    Storage::delete($documento_upd->path);
                    $this->deleteThumbImg($documento_upd->path);
                }
            }

            $cte_doc = ClienteDocumento::updateOrCreate(
                ['cliente_id' => $cliente->id, 'documento_id' => $data_store['documento_id']],
                [
                    'path' => $data_store['path'],
                    'expiracion' => isset($data_store['expiracion']) ? $data_store['expiracion'] : null,
                    'excluir' => $data_store['excluir']
                ]
            );

            $cte_doc->thumb = $thumb;

            if ($cte_doc) {
                $response['json']['data'] = $cte_doc;
                $response['json']['success'] = true;
                $response['json']['message'] = 'Documento cargado correctamente.';
                $response['code'] = 200;
            } else{
                Storage::delete($data_store['path']);
            }
        }

        return response()->json($response['json'], $response['code']);
    }

    public function destroy(ClienteDocumento $clienteDocumento){
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se eliminó documento'], 'code' => 409];

        if (Storage::delete($clienteDocumento->path)) {
            $del = $clienteDocumento->delete();

            if ($del) {
                $response['json']['success'] = true;
                $response['json']['message'] = 'Documento eliminado correctamente.';
                $response['code'] = 200;
            }
        }

        return response()->json($response['json'], $response['code']);
    }

    public function downloadDocs(Cliente $cliente, ClienteDocumento $documento = null, Request $request){
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se pudo descargar documento'], 'code' => 409];

        $expiration = now()->addHour();
        if ($documento === null) {
            $expiration = now()->addMinutes(15);
        }

        if ($documento !== null && $cliente->id === $documento->cliente_id) {
            $response['json']['success'] = true;
            $response['json']['data']['url'] = URL::signedRoute(
                'files.download',
                ['cliente' => $cliente->id, 'documento' => $documento->id],
                $expiration
            );
            $response['json']['message'] = 'Se generó correctamente la URL de documentación para este cliente';
            $response['code'] = 200;
        } else {
            $documentos = '';
            if (isset($request->documentos)) {
                $documentos = json_decode($request->documentos);
            }
            $validator = Validator::make(['documentos' => $documentos], [
                'documentos' => 'required|array|min:1',
                'documentos.*' => 'required|numeric|exists:clientes_documentos,id'
            ]);

            if ($validator->fails()) {
                $response['json']['errors'] = $validator->errors()->toArray();
            } else{
                $response['json']['success'] = true;
                $response['json']['data']['url'] = URL::signedRoute(
                    'files.download',
                    ['cliente' => $cliente->id, 'documento' => null, "documentos" => json_encode($validator->validated()['documentos'])],
                    $expiration
                );
                $response['json']['message'] = 'Se generó correctamente la URL de documentación para este cliente';
                $response['code'] = 200;
            }
        }
        return response()->json($response['json'], $response['code']);
    }
}
