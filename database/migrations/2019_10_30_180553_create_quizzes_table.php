<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bookquiz')->create('quizzes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('book_usuarios.users');
            $table->unsignedBigInteger('ilha_id');
            $table->foreign('ilha_id')->references('id')->on('book_usuarios.ilhas');
            $table->string('ilhas')->nullable();
            $table->timestamp('validity');
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
        Schema::dropIfExists('quizzes');
    }
}
