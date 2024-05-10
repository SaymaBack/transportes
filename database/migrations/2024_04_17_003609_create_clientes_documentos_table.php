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
        Schema::create('cat_documentos', function(Blueprint $table){
            $table->id();
            $table->string('nombre');
            $table->boolean('require_token');
            $table->boolean('active');
            $table->json('tipos_clientes');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('clientes_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('documento_id')->constrained('cat_documentos');
            $table->string('path')->nullable();
            $table->date('expiracion')->nullable();
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
        Schema::dropIfExists('clientes_documentos');
        Schema::dropIfExists('cat_documentos');
    }
};
