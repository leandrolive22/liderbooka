<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Connection;

class LaudosModelos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    protected $connection = 'bookmonitoria';

    public function up()
    {
        Schema::connection($this->connection)->create('laudos_modelos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->string('tipo_monitoria');
            $table->integer('utilizacoes')->default(0);
            $table->unsignedBigInteger('carteira_id');
            $table->foreign('carteira_id')->references('id')->on('book_usuarios.carteiras')->onDelete('no action')->onUpdate('no action');
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
        Schema::dropIfExists('laudos_modelos');
    }
}
