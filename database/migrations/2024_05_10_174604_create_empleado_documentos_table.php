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
        // Documentos
        Schema::create('cat_empleados_documentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->json('aplica_puestos');
            $table->boolean('activo')->default(true);
        });

        Schema::create('empleado_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained('empleados');
            $table->foreignId('empleado_documento_id')->constrained('cat_empleados_documentos');
            $table->string('path');
            $table->date('expiracion');
            $table->boolean('excluir');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleado_documentos');
        Schema::dropIfExists('cat_empleados_documentos');
    }
};
