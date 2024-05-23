<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\CatTipoNomina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CatTipoNominaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $data = CatTipoNomina::all();

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
            'nombre' => 'required|unique:cat_tipos_nomina|string'
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{
            $data = CatTipoNomina::create($validator->validated());

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
    public function show(CatTipoNomina $catTipoNomina)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        if($catTipoNomina){
            $response['json']['success'] = true;
            $response['json']['message'] = "Centro de costo obtenido correctamente";
            $response['json']['data'] = $catTipoNomina;
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CatTipoNomina $catTipoNomina)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $validator = Validator::make($request->all(), [
            'nombre' => ['required', Rule::unique('cat_tipos_nomina')->ignore($catTipoNomina->id), 'string'],
            'activo' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{
            $data = $catTipoNomina->update($validator->validated());

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
    public function destroy(CatTipoNomina $catTipoNomina)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $del = $catTipoNomina->delete();

        if ($del) {
            $response['json']['success'] = true;
            $response['json']['message'] = "Registro eliminado correctamente";
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }
}
