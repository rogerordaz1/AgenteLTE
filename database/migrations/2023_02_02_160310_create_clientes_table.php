<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_oficina_comercial')->references('id')->on('ocomerciales');
            $table->foreignId('id_agente')->nullable()->references('id')->on('agentes');
            $table->string('servicio')->unique();
            $table->string('sector');
            $table->string('nombre');
            $table->string('direccion');
            $table->string('cuenta_bancaria');
            $table->date('fecha_alta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
};
