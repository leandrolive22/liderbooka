<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Connection;

class LaudosItens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'bookmonitoria';

    public function up()
    {
        Schema::connection($this->connection)->create('laudos_itens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('modelo_id');
            $table->foreign('modelo_id')->references('id')->on('book_monitoria.laudos_modelos')->onDelete('no action')->onUpdate('no action');
            $table->string('numero',300);
            $table->string('questao',300);
            $table->string('sinalizacao',300);
            $table->string('procedimento',300)->default('Conforme;Não Conforme; Não Avaliado');
            $table->string('valor')->nullable();
            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('book_usuarios.users')->onDelete('no action')->onUpdate('no action');
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
        Schema::dropIfExists('laudos_itens');
    }
}
