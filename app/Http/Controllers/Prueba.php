<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Prueba extends Controller
{
    public function index(Request $request)
    {


        return response()->json(['success' => true, 'message' => "Exito!"], 200);
    }


    public function show(Request $request,$id)
    {
    }


    public function create(Request $request)
    {
    }


    public function update(Request $request)
    {
    }


    public function delete(Request $request,$id)
    {
    }


    public function patch(Request $request,$id)
    {
    }
}
