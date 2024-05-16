<?php

namespace App\Http\Controllers\Capitalhumano;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se obtuvo ningún registro, intente más tarde.'], 'code' => 409];

        $validator = Validator::make($request->all(),['activo' => 'required|boolean']);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{
            $empleados = Empleado::all()->where('activo', $validator->validated()['activo']);

            $empleados->map(function($element){
                $element->foto = asset(Storage::url($element->foto));
            });

            $response['json']['success'] = true;
            $response['json']['message'] = 'Registros de empleados obtenidos correctamente';
            $response['json']['data'] = $empleados;
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se pudo insertar el registro, intente más tarde.'], 'code' => 409];

        $validator = Validator::make($request->all(),[
            'nombre' => 'required|string',
            'ape_pat' => 'required|string',
            'ape_mat' => 'required|string',
            'fecha_nac' => 'required|date',
            'rfc' => 'required|unique:empleados',
            'curp' => 'required|unique:empleados',
            'imss' => 'required|unique:empleados',
            'num_empleado' => 'nullable|numeric|unique:empleados',
            'departamento_id' => 'required|exists:cat_departamentos,id',
            'puesto_id' => 'required|exists:cat_puestos,id',
            'tipo_nomina_id' => 'required|exists:cat_tipos_nomina,id',
            'centro_costo_id' => 'required|exists:cat_centros_costo,id',
            'sueldo_diario' => 'required|numeric',
            'integrado' => 'required',
            'clabe' => 'required|string',
            'banco' => 'required|string',
            'foto' => 'required|file|extensions:jpg,png,jpeg',
            'alta' => 'required|date',
            'activo' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{
            $validated = $validator->validated();

            $file = $request->foto;
            $filename = Uuid::uuid1();
            $path = $file->storeAs('public/fotos', $filename . '.' . $file->extension());
            $validated['foto'] = $path;

            $empleado = Empleado::create($validated);

            if ($empleado) {
                $response['json']['success'] = true;
                $response['json']['message'] = 'Registro de empleado almacenado correctamente';
                $response['json']['data'] = $empleado;
                $response['code'] = 200;
            }
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error, no se obtuvo el registro, intente más tarde.'], 'code' => 409];

        if ($empleado){

            $empleado->foto = asset(Storage::url($empleado->foto));

            $response['json']['success'] = true;
            $response['json']['message'] = 'Registro obtenido correctamente';
            $response['json']['data'] = $empleado;
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $validator = Validator::make($request->all(),[
            'nombre' => 'required|string',
            'ape_pat' => 'required|string',
            'ape_mat' => 'required|string',
            'fecha_nac' => 'required|date',
            'rfc' => ['required', Rule::unique('empleados')->ignore($empleado->id)],
            'curp' => ['required', Rule::unique('empleados')->ignore($empleado->id)],
            'imss' => ['required', Rule::unique('empleados')->ignore($empleado->id)],
            'num_empleado' => ['nullable','numeric', Rule::unique('empleados')->ignore($empleado->id)],
            'departamento_id' => 'required|exists:cat_departamentos,id',
            'puesto_id' => 'required|exists:cat_puestos,id',
            'tipo_nomina_id' => 'required|exists:cat_tipos_nomina,id',
            'centro_costo_id' => 'required|exists:cat_centros_costo,id',
            'sueldo_diario' => 'required|numeric',
            'integrado' => 'required',
            'clabe' => 'required|string',
            'banco' => 'required|string',
            'foto' => 'nullable|file|extensions:jpg,png,jpeg',
            'alta' => 'required|date',
            'activo' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            $response['json']['errors'] = $validator->errors()->toArray();
        } else{
            $validated = $validator->validated();

            if ($request->foto) {
                $foto_del = Storage::delete($empleado->foto);
                if ($foto_del) {
                    $file = $request->foto;
                    $filename = Uuid::uuid1();
                    $path = $file->storeAs('public/fotos', $filename . '.' . $file->extension());
                    $validated['foto'] = $path;
                }
            }

            $empleado->update($validated);

            $response['json']['success'] = true;
            $response['json']['message'] = 'Registro de empleado actualizado correctamente';
            $response['json']['data'] = $empleado;
            $response['code'] = 200;
        }


        return response()->json($response['json'], $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $del = $empleado->delete();

        if ($del) {
            $response['json']['success'] = true;
            $response['json']['message'] = 'Registro de empleado eliminado correctamente';
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }

    public function cambiaEstatusEmpleado(Empleado $empleado){
        $response = ['json' => ['success' => false, 'message'=> 'Error'], 'code' => 409];

        $estatus = $empleado->estatus ? false : true;
        $del = $empleado->update(['activo' => $estatus]);

        if ($del) {
            $response['json']['success'] = true;
            $response['json']['message'] = 'Cambio el estatus correctamente';
            $response['code'] = 200;
        }

        return response()->json($response['json'], $response['code']);
    }
}
