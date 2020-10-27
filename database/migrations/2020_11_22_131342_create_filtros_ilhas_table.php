<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Connection;

class CreateFiltrosIlhasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bookmateriais')->create('filtros_ilhas', function (Blueprint $table) {
            $table->unsignedBigInteger('material_id');
            $table->foreign('material_id')->references('id')->on('book_materiais.materiais_apoio')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('ilha_id')->nullable();
            $table->foreign('ilha_id')->references('id')->on('book_usuarios.ilhas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('filtros_ilhas');
    }
}
