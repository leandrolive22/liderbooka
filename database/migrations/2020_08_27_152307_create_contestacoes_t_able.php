<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bookmonitoria')->create('contestacoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('obs')->nullable();
            $table->integer('passo');
            $table->string('status');
            $table->unsignedBigInteger('motivo_id');
            $table->foreign('motivo_id')->references('id')->on('book_monitoria.motivos_contestar')->onUpdate('no action')->onDelete('no action');
            $table->unsignedBigInteger('monitoria_id');
            $table->foreign('monitoria')->references('id')->on('book_monitoria.monitorias')->onUpdate('no action')->onDelete('no action');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contestacoes_t_able');
    }
}
