<?php

namespace App\Http\Controllers;

use App\Models\FormaPago;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormaPagoController extends Controller
{
    public function index(): JsonResponse{
        $response = FormaPago::all();

        if ($response) {
            return response()->json([
                'success' => true,
                'message' => 'Catalogo de formas de pago obtenido correctamente.',
                'data' => $response
            ], 200);
        }

        return response()->json([
                'success' => false,
                'message' => 'Error no se pudo obtener el catalogo'
            ], 409);
    }
}
