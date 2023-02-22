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
        Schema::create('n_agredados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('servicio');

            $table->foreignId('id_agente')->references('id')->on('agentes');
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
        Schema::dropIfExists('n_agredados');
    }
};
