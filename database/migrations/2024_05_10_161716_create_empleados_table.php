<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /* CATALOGOS */

        // Departamentos
        Schema::create('cat_departamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->boolean('activo')->default(true);
        });

        // Tipos de Nomina
        Schema::create('cat_tipos_nomina', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->boolean('activo')->default(true);
        });

        // Puestos
        Schema::create('cat_puestos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->boolean('activo')->default(true);
        });

        // Centros de costo
        Schema::create('cat_centros_costo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->boolean('activo')->default(true);
        });

        /* Empleados */
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ape_mat');
            $table->string('ape_pat');
            $table->date('fecha_nac');
            $table->string('rfc');
            $table->string('curp');
            $table->string('imss');
            $table->string('num_empleado');
            $table->foreignId('departamento_id')->constrained('cat_departamentos');
            $table->foreignId('puesto_id')->constrained('cat_puestos');
            $table->foreignId('tipo_nomina_id')->constrained('cat_tipos_nomina');
            $table->foreignId('centro_costo_id')->constrained('cat_centros_costo');
            $table->float('sueldo_diario');
            $table->string('integrado');
            $table->string('clabe');
            $table->string('banco');
            $table->string('foto');
            $table->date('alta');
            $table->boolean('estatus');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
        Schema::dropIfExists('cat_departamentos');
        Schema::dropIfExists('cat_tipos_nomina');
        Schema::dropIfExists('cat_puestos');
        Schema::dropIfExists('cat_centros_costo');
    }
};
