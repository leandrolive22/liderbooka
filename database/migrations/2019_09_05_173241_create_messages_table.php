<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Connection;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bookchats')->create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('content');
            $table->unsignedBigInteger('interlocutor_id');
            $table->foreign('interlocutor_id')->references('id')->on('book_usuarios.users')->onDelete('cascade')->onUpdate('cascade');;
            $table->unsignedBigInteger('speaker_id');
            $table->foreign('speaker_id')->references('id')->on('book_usuarios.users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');;
            $table->boolean('readed');
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
        Schema::dropIfExists('messages');
    }
}
