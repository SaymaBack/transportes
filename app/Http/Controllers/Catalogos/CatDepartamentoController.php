<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\CatDepartamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CatDepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $data = CatDepartamento::all();

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
            'nombre' => 'required|unique:cat_departamentos|string'
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{
            $data = CatDepartamento::create($validator->validated());

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
    public function show(CatDepartamento $catDepartamento)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        if($catDepartamento){
            $response['json']['success'] = true;
            $response['json']['message'] = "Registro obtenido correctamente";
            $response['json']['data'] = $catDepartamento;
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CatDepartamento $catDepartamento)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $validator = Validator::make($request->all(), [
            'nombre' => ['required', Rule::unique('cat_departamentos')->ignore($catDepartamento->id), 'string'],
            'activo' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{
            $data = $catDepartamento->update($validator->validated());

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
    public function destroy(CatDepartamento $catDepartamento)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $del = $catDepartamento->delete();

        if ($del) {
            $response['json']['success'] = true;
            $response['json']['message'] = "Registro eliminado correctamente";
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }
}
