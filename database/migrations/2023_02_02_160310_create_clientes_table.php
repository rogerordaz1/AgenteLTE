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
            $table->string('servicio')->unique();
            $table->string('agrupacion');
            $table->string('sector');
            $table->string('nombre');
            $table->string('direccion');
            $table->string('cuenta_bancaria')->nullable();
            $table->string('fecha_alta')->nullable();
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
