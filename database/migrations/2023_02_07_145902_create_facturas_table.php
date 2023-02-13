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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->string('oficina');
            $table->string('agrupacion');
            $table->string('cuenta');
            $table->string('no_factura');
            $table->string('nombre_cliente');
            $table->string('servicio_cliente');
            $table->foreign('servicio_cliente')->references('servicio')->on('clientes');
            $table->float('total');
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
        Schema::dropIfExists('facturas');
    }
};
