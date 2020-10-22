<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::connection('bookrelatorios')->create('quiz_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('action');
            $table->unsignedBigInteger('quiz_id')->nullable();
            $table->foreign('quiz_id')->references('id')->on('book_quizzes.quizzes')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('book_usuarios.users')->onDelete('no action')->onUpdate('no action');
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
        //
    }
}
