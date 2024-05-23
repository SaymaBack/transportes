<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\TipoCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index(){
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se obtuvieron clientes'], 'code' => 409];

        $clientes = Cliente::select('clientes.id', 'clientes.razon_social', 'clientes.rfc', 'clientes.email', 'tc.nombre as tipo_cliente', 'clientes.estatus')
                ->join('tipo_cliente as tc', 'clientes.tipo_cliente_id', '=', 'tc.id')
                ->orderBy('id', 'desc')
                ->get();

        if (isset($clientes)) {
            $response['json']['data'] = $clientes;
            $response['json']['success'] = true;
            $response['json']['message'] = 'Clientes obtenidos correctamente.';
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

    public function tiposClientes(){
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se obtuvieron tiepos de clientes'], 'code' => 409];

        $clientes = TipoCliente::select('id', 'nombre')
                ->get();

        if (isset($clientes)) {
            $response['json']['data'] = $clientes;
            $response['json']['success'] = true;
            $response['json']['message'] = 'Catalogo de tipos de clientes obtenidos correctamente.';
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

    public function store(Request $request){
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se pudo almacenar el cliente'], 'code' => 409];

        $validator = Validator::make($request->all(), [
            'razon_social' => 'required|unique:clientes|string',
            'direccion' => 'required|string',
            'rfc' => 'required|unique:clientes|string',
            'email' => 'required|email',
            'telefono' => 'required|string',
            'codigo_postal' => 'required|string',
            'ciudad' => 'required|string',
            'estado' => 'required|string',
            'plazo' => 'required|numeric',
            'regimen_fiscal' => 'required|exists:App\Models\RegimenFiscal,c_RegimenFiscal',
            'contacto_administrativo' => 'required|string',
            'contacto_operativo' => 'nullable|string',
            'tipo_cliente_id' => 'required|exists:App\Models\TipoCliente,id',
            'forma_pago' => 'required|exists:App\Models\FormaPago,c_FormaPago',
            'uso_cfdi' => 'required|exists:App\Models\UsoCFDI,c_UsoCFDI',
            'estatus' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else {
            $cliente = Cliente::create($validator->validated());

            if (isset($cliente)) {
                $response['json']['data'] = $cliente;
                $response['json']['success'] = true;
                $response['json']['message'] = 'Cliente almacenado correctamente.';
                $response['code'] = 200;
            }
        }

        return response()->json($response['json'], $response['code']);
    }

    public function update(Cliente $cliente,Request $request){
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se pudo actualizar cliente'], 'code' => 409];

        $validator = Validator::make($request->all(), [
            'razon_social' => ['required',Rule::unique('clientes')->ignore($cliente->id),'string'],
            'direccion' => 'required|string',
            'rfc' => ['required',Rule::unique('clientes')->ignore($cliente->id),'string'],
            'email' => 'required|email',
            'telefono' => 'required|string',
            'codigo_postal' => 'required|string',
            'ciudad' => 'required|string',
            'estado' => 'required|string',
            'plazo' => 'required|numeric',
            'regimen_fiscal' => 'required|exists:App\Models\RegimenFiscal,c_RegimenFiscal',
            'contacto_administrativo' => 'required|string',
            'contacto_operativo' => 'nullable|string',
            'tipo_cliente_id' => 'required|exists:App\Models\TipoCliente,id',
            'forma_pago' => 'required|exists:App\Models\FormaPago,c_FormaPago',
            'uso_cfdi' => 'required|exists:App\Models\UsoCFDI,c_UsoCFDI',
            'estatus' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else {
            $cliente->update($validator->validated());

            if (isset($cliente)) {
                $response['json']['data'] = $cliente;
                $response['json']['success'] = true;
                $response['json']['message'] = 'Cliente actualizado correctamente.';
                $response['code'] = 200;
            }
        }

        return response()->json($response['json'], $response['code']);
    }

    public function show(Cliente $cliente){
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se obtuvo cliente'], 'code' => 409];

        if (isset($cliente)) {
            $response['json']['data'] = $cliente;
            $response['json']['success'] = true;
            $response['json']['message'] = 'Cliente obtenido correctamente.';
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

    public function destroy(Cliente $cliente){
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se eliminó cliente'], 'code' => 409];

        $res = $cliente->delete();
        if ($res) {
            $response['json']['success'] = true;
            $response['json']['message'] = 'Cliente eliminado correctamente.';
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

    public function cambiaEstatusCliente(Cliente $cliente){
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se actualizó el estatus del cliente'], 'code' => 409];

        $estatusCliente = $cliente->estatus ? false : true;
        $res = $cliente->update(['estatus' => $estatusCliente]);

        if ($res) {
            $response['json']['success'] = true;
            $response['json']['message'] = 'Estatus de cliente actualizado correctamente.';
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

}
