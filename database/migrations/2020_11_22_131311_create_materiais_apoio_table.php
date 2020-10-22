<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Connection;

class CreateMateriaisApoioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bookmateriais')->create('materiais_apoio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('file_path');
            $table->integer('view_number')->default(0)->nullable();
            $table->unsignedBigInteger('tipo_id');
            $table->foreign('tipo_id')->references('id')->on('book_materiais.tipos_materiais')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('book_usuarios.users')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('materiais_apoio');
    }
}
