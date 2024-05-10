<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\RegimenFiscal;
use Illuminate\Http\JsonResponse;

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
