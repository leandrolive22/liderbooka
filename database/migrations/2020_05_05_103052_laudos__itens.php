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
            $table->unsignedBigInteger('id_laudo_item');
            $table->foreign('id_laudo_item')->references('id')->on('book_monitoria.laudos_modelos')->onDelete('no action')->onUpdate('no action');
            $table->string('value')->nullable();
            $table->float('value_pct',8,6);
            $table->string('pergunta',300);
            $table->string('obs',300);
            $table->integer('ncg')->nullable();
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
