<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Login extends Controller
{
    public function Auth(Request $request)
    {
        $data = $request->all();
        // $validation = new valida();

        echo json_encode(gettype($data));
    }
}
