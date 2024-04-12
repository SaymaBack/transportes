<?php

namespace App\Http\Controllers;

use App\Models\RegimenFiscal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegimenFiscalController extends Controller
{
    public function index(): JsonResponse{
        $response = RegimenFiscal::all();

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
