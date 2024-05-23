<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\CatCentroCosto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CatCentroCostoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se pudio obtener catalogo'], 'code' => 409];

        $data = CatCentroCosto::all();

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
        $response = ['json' => ['success' => false, 'message'=> 'Error, error al guardar el centro de costo.'], 'code' => 409];

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:cat_centros_costo|string'
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{
            $data = CatCentroCosto::create($validator->validated());

            if ($data) {
                $response['json']['success'] = true;
                $response['json']['message'] = "Se guardo correctamente el centro de costo.";
                $response['json']['data'] = $data;
                $response['code'] = 200;
            }
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Display the specified resource.
     */
    public function show(CatCentroCosto $catCentroCosto)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error al obtener centro de costo'], 'code' => 409];

        if($catCentroCosto){
            $response['json']['success'] = true;
            $response['json']['message'] = "Centro de costo obtenido correctamente";
            $response['json']['data'] = $catCentroCosto;
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CatCentroCosto $catCentroCosto)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $validator = Validator::make($request->all(), [
            'nombre' => ['required', Rule::unique('cat_centros_costo')->ignore($catCentroCosto->id), 'string'],
            'activo' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{
            $data = $catCentroCosto->update($validator->validated());

            if ($data) {
                $response['json']['success'] = true;
                $response['json']['message'] = "Se guardo correctamente el centro de costo.";
                $response['json']['data'] = $data;
                $response['code'] = 200;
            }
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CatCentroCosto $catCentroCosto)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $del = $catCentroCosto->delete();

        if ($del) {
            $response['json']['success'] = true;
            $response['json']['message'] = "Registro eliminado correctamente";
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }
}
