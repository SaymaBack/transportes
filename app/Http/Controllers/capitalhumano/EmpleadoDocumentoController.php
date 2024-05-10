<?php

namespace App\Http\Controllers\Capitalhumano;

use App\Http\Controllers\Controller;
use App\Models\EmpleadoDocumento;
use Illuminate\Http\Request;

class EmpleadoDocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

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
    public function update(Request $request, EmpleadoDocumento $empleadoDocumento)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmpleadoDocumento $empleadoDocumento)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        return response()->json($response['json'], $response['code']);
    }
}
