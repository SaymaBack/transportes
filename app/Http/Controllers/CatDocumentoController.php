<?php

namespace App\Http\Controllers;

use App\Models\CatDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CatDocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se obtuvo catalogo de documentos'], 'code' => 409];

        $validator = Validator::make($request->all(),[
            'tipo_cliente' => 'nullable|exists:tipo_cliente,id',
            'cliente' => 'nullable|exists:clientes,id'
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{
            $validated = $validator->validated();
            $catDocs = CatDocumento::all();

            if (isset($validated['tipo_cliente'])) {
                foreach ($catDocs as $key => $value) {
                    if (!in_array($validated['tipo_cliente'], $value->tipos_clientes)) {
                        unset($catDocs[$key]);
                    }
                }
            }

            if ($catDocs) {
                $response['json']['data'] = $catDocs;
                $response['json']['success'] = true;
                $response['json']['message'] = 'Catalogo de Documentos obtenido correctamente.';
                $response['code'] = 200;
            }
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se guardó documento del catalogo'], 'code' => 409];

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:cat_documentos|string',
            'require_token' => 'required|boolean',
            'active' => 'required|boolean',
            'tipos_clientes' => 'required|array|min:1',
            'tipos_clientes.*' => 'required|numeric|distinct|exists:tipo_cliente,id'
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{

            $catDocumento = CatDocumento::create($validator->validated());

            if ($catDocumento) {
                $response['json']['data'] = $catDocumento;
                $response['json']['success'] = true;
                $response['json']['message'] = 'Documento del catalogo cargado correctamente.';
                $response['code'] = 200;
            }
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Display the specified resource.
     */
    public function show(CatDocumento $catDocumento)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se obtuvo documento del catalogo'], 'code' => 409];

        if ($catDocumento) {
            $response['json']['data'] = $catDocumento;
            $response['json']['success'] = true;
            $response['json']['message'] = 'Documento del catalogo obtenido correctamente.';
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CatDocumento $catDocumento)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se actualizó documento del catalogo'], 'code' => 409];

        $validator = Validator::make($request->all(), [
            'nombre' => ['required', Rule::unique('cat_documentos')->ignore($catDocumento->id),'string'],
            'require_token' => 'required|boolean',
            'active' => 'required|boolean',
            'tipos_clientes' => 'required|array|min:1',
            'tipos_clientes.*' => 'required|numeric|distinct|exists:tipo_cliente,id'
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{

            $res = $catDocumento->update($validator->validated());

            if ($res) {
                $response['json']['data'] = $catDocumento;
                $response['json']['success'] = true;
                $response['json']['message'] = 'Documento del catalogo actualizado correctamente.';
                $response['code'] = 200;
            }
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CatDocumento $catDocumento)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se eliminó documento del catalogo'], 'code' => 409];

        $del = $catDocumento->delete();

        if ($del) {
            $response['json']['success'] = true;
            $response['json']['message'] = 'Documento del catalogo eliminado correctamente.';
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

    public function cambiaEstatusDocumento(CatDocumento $catDocumento){
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se actualizó el estatus del cliente'], 'code' => 409];

        $activeDoc = $catDocumento->active ? false : true;
        $res = $catDocumento->update(['active' => $activeDoc]);

        if ($res) {
            $response['json']['success'] = true;
            $response['json']['message'] = 'Estatus de cliente actualizado correctamente.';
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }
}
