<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ClienteDocumento;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Ramsey\Uuid\Uuid;

class ClienteDocumentoController extends Controller
{
    public function index(Cliente $cliente): JsonResponse{
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se obtuvieron documentos del cliente'], 'code' => 409];

        $documentos = $cliente->documentos;

        if ($documentos !== null && count($documentos) > 0) {
            $response['json']['data'] = $documentos;
            $response['json']['success'] = true;
            $response['json']['message'] = 'Documentos obtenidos correctamente.';
            $response['code'] = 200;
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
            'documento_id' => ['required','exists:cat_documentos,id',
                                Rule::unique('clientes_documentos')
                                    ->where(fn (Builder $query) => $query->where('cliente_id', $cliente->id))],
            'documento' => [Rule::requiredIf(!$request->excluir), File::types(['pdf', 'jpg', 'jpeg', 'gif', 'png']), 'nullable'],
            'expiracion' => 'nullable|date'
        ]);

        if($validator->fails()){
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{
            $data_store = $validator->validated();
            if (!$data_store['excluir']) {
                $file = $request->documento;
                $filename = Uuid::uuid1();
                $path = $file->storeAs('public/documentos/', $filename . '.' . $file->extension());
                $data_store['path'] = $path;
                $data_store['file_name'] = $filename;
            }
            $data_store['cliente_id'] = $cliente->id;
            $cte_doc = ClienteDocumento::create($data_store);

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

    public function update(ClienteDocumento $clienteDocumento, Request $request){

    }

    public function destroy(ClienteDocumento $clienteDocumento){
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se eliminó documento'], 'code' => 409];

        $del = $clienteDocumento->delete();
        if ($del) {
            $response['json']['success'] = true;
            $response['json']['message'] = 'Documento eliminado correctamente.';
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }
}
