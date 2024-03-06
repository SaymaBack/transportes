<?php

namespace App\Http\Controllers;

use App\Http\Implementation\UserAuth;
use App\Http\Implementation\ValidationUser;

use App\Http\Implementation\UserAuthjwt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Login extends Controller
{
    /**
    * @OA\Post(
    *     path="/api/v1/login",
    *     summary="Autenticacion y generacion de token JWT",
    *     tags={"Auth"},
    *     @OA\RequestBody(
    *       @OA\MediaType(
    *           mediaType="application/json",
    *           @OA\Schema(
    *               @OA\Property(
    *                   property="usuario",
    *                   type="string"
    *               ),
    *               @OA\Property(
    *                   property="password",
    *                   type="string"
    *               ),
    *               example={"usuario": "test", "password": "123456"}
    *           )
    *       )
    *     ),
    *     @OA\Response(response="200", description="Login successful"),
    *     @OA\Response(response="401", description="Invalid credentials"),
    *     @OA\Response(response="409", description="Error; Bad request")
    * )
    */
    public function Auth(Request $request): JsonResponse
    {
        $data = $request->all();

        $validation = new ValidationUser();
        $response = $validation->validateExistUsername($data);

        if (!$response["success"]) {
            return response()->json(['success' => false, 'message' => $response["message"]], 409);
        }

        $response = $validation->validateExistPassword($data);
        if (!$response["success"]) {
            return response()->json(['success' => false, 'message' => $response["message"]], 409);
        }

        $validation = new UserAuth();
        $response =  $validation->authenticate($data);

        if (!$response["success"]) {
            return response()->json(['success' => false, 'message' => $response["message"]], 409);
        }
        $user = $response['data'];
        $validation = new UserAuthjwt();
        $response = $validation->generarToke($response["data"]->username, $response["data"]->id);


        if (!$response["success"]) {
            return response()->json(['success' => false, 'message' => $response["message"]], $response["status"]);
        }

        return response()->json(['success' => true, 'message' => $response["message"],
                "data" => [
                    "access_token" => $response["token"],
                    "user" => $user
                ]
            ], $response["status"]);
    }
}
