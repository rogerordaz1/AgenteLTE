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
            $table->foreign('servicio_cliente')->references('servicio')->on('clientes')->onDelete('cascade');
            $table->string('cuota')->nullable();
            $table->string('LDN')->nullable();
            $table->string('LDI')->nullable();
            $table->string('local')->nullable();
            $table->string('otros')->nullable();
            $table->string('impuesto')->nullable();
            $table->string('comision')->nullable();
            $table->string('facturado')->nullable();
            $table->string('atrasos')->nullable();
            $table->string('total');
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
