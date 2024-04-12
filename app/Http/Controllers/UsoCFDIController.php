<?php

namespace App\Http\Controllers;

use App\Models\UsoCFDI;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsoCFDIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse{
        $response = UsoCFDI::all();

        if ($response) {
            return response()->json([
                'success' => true,
                'message' => 'Catálogo obtenido correctamente.',
                'data' => $response
            ], 200);
        }

        return response()->json([
                'success' => false,
                'message' => 'Error no se pudo obtener el catalogo'
            ], 409);
    }

}
