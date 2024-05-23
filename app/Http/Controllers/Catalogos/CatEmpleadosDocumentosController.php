<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\CatEmpleadosDocumentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CatEmpleadosDocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $data = CatEmpleadosDocumentos::all();

        if ($data) {
            $response['json']['success'] = true;
            $response['json']['message'] = "Registros obtenidos correctamente";
            $response['json']['data'] = $data;
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:cat_empleados_documentos|string',
            /* 'aplica_puestos' => 'required|array|min:1',
            'aplica_puestos.*' => 'required|numeric|distinct|exists:cat_puestos,id' */
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{
            $data = CatEmpleadosDocumentos::create($validator->validated());

            if ($data) {
                $response['json']['success'] = true;
                $response['json']['message'] = "Se guardo correctamente el registro.";
                $response['json']['data'] = $data;
                $response['code'] = 200;
            }
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Display the specified resource.
     */
    public function show(CatEmpleadosDocumentos $catEmpleadosDocumento)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        if($catEmpleadosDocumento){
            $response['json']['success'] = true;
            $response['json']['message'] = "Registro obtenido correctamente";
            $response['json']['data'] = $catEmpleadosDocumento;
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CatEmpleadosDocumentos $catEmpleadosDocumento)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $validator = Validator::make($request->all(), [
            'nombre' => ['required', Rule::unique('cat_departamentos')->ignore($catEmpleadosDocumento->id), 'string'],
            /* 'aplica_puestos' => 'required|array|min:1',
            'aplica_puestos.*' => 'required|numeric|distinct|exists:cat_puestos,id', */
            'activo' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{
            $data = $catEmpleadosDocumento->update($validator->validated());

            if ($data) {
                $response['json']['success'] = true;
                $response['json']['message'] = "Se actualizo correctamente el registro.";
                $response['json']['data'] = $data;
                $response['code'] = 200;
            }
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CatEmpleadosDocumentos $catEmpleadosDocumento)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $del = $catEmpleadosDocumento->delete();

        if ($del) {
            $response['json']['success'] = true;
            $response['json']['message'] = "Registro eliminado correctamente";
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }
}
