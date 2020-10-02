<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Connection;

class CreateBaseDadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bookmateriais')->create('base_dados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cpf');
            $table->string('CIC_DVR');
            $table->string('Politica_pega');
            $table->string('flag_unif');
            $table->string('flag_politica');
            $table->string('Parcela_maxima');
            $table->string('Forma_pagamento');
            $table->string('desconto_avista');
            $table->string('desconto_avista2a4x');
            $table->string('desconto_avista5a12x');
            $table->string('desconto_avista13a24x');
            $table->string('desconto_avista25a72x');
            $table->string('taxa_avista');
            $table->string('taxa_2a4x');
            $table->string('taxa_5a12x');
            $table->string('taxa_13a24x');
            $table->string('taxa_25a72x');
            $table->string('CAMPANHA');
            $table->string('flag_cartoes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('base_dados');
    }
}
