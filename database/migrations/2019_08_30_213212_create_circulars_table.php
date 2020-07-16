<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Connection;


class CreateCircularsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'bookmateriais';

    public function up()
    {
        Schema::connection('bookmateriais')->create('circulares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('number');
            $table->year('year');
            $table->string('file_path');
            $table->string('status');
            $table->text('tags');
            $table->unsignedBigInteger('setor_id');
            $table->foreign('setor_id')->references('id')->on('book_usuarios.setores')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('ilha_id');
            $table->foreign('ilha_id')->references('id')->on('book_usuarios.ilhas')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('book_usuarios.users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('circulars');
    }
}
