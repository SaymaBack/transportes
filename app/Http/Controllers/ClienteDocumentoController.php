<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ClienteDocumento;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
