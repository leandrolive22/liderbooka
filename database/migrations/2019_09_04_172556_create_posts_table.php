<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Connection;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bookposts')->create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('descript')->nullable();
            $table->string('file_path')->nullable();
            $table->integer('comment_number');
            $table->integer('reactions_number');
            $table->integer('view_number');
            $table->integer('priority');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('book_usuarios.users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('ilha_id');
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
        Schema::dropIfExists('posts');
    }
}
