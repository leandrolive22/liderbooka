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
            $table->string('titulo');
            $table->string('numero',100);
            $table->string('questao');
            $table->string('sinalizacao');
            $table->string('procedimento');
            $table->float('valor',5,2);
            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('book_usuarios.users')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('modelo_id');
            $table->foreign('modelo_id')->references('id')->on('laudos_modelos')->onDelete('no action')->onUpdate('no action');
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
