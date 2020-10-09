<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Connection;

class CreateBaseConsultaSaldoRemanescenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bookmateriais')->create('base_consulta_saldo_remanescente', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('Nr_Contrato_Origem');
            $table->string('Escritorio');
            $table->unsignedBigInteger('Tel_Escritorio_1');
            $table->unsignedBigInteger('Tel_Escritorio_2');
            $table->text('Endereco_Escritorio');
            $table->string('Cidade_Escritorio');
            $table->string('UF_Escritorio',2);
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
        Schema::dropIfExists('base_consulta_saldo_remanescente');
    }
}
