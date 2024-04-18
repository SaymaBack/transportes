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
        Schema::create('tipo_cliente', function(Blueprint $table){
            $table->id();
            $table->string('nombre');
            $table->softDeletes();
        });

        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('razon_social');
            $table->longText('direccion');
            $table->string('rfc');
            $table->string('email');
            $table->string('telefono');
            $table->string('codigo_postal');
            $table->string('ciudad');
            $table->string('estado');
            $table->string('plazo');
            $table->string('regimen_fiscal', 15);
            $table->string('contacto_administrativo');
            $table->string('contacto_operativo')->nullable();
            $table->foreignId('tipo_cliente_id')->constrained('tipo_cliente');
            $table->string('forma_pago', 11);
            $table->string('uso_cfdi', 9);
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
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('tipo_cliente');
    }
};
