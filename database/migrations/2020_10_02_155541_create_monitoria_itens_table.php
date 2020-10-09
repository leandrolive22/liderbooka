<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Connection;

class CreateMonitoriaItensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'bookmonitoria';

    public function up()
    {
        Schema::connection($this->connection)->create('monitoria_itens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_laudo_item');
            $table->foreign('id_laudo_item')->references('id')->on('book_monitoria.laudos_modelos')->onDelete('no action')->onUpdate('no action');
            $table->string('value')->nullable();
            $table->float('value_pct',8,2);
            $table->string('pergunta')->nullable();
            $table->string('obs')->nullable();
            $table->tinyInteger('ncg')->nullable();
            $table->unsignedBigInteger('monitoria_id');
            $table->foreign('monitoria_id')->references('id')->on('book_monitoria.monitorias')->onDelete('no action')->onUpdate('no action');
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
        Schema::dropIfExists('monitoria_itens');
    }
}
