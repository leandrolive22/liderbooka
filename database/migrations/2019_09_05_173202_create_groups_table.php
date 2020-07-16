<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Connection;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bookchats')->create('groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('conversation_title');
            $table->unsignedBigInteger('ilha_id')->nullable();
            $table->foreign('ilha_id')->references('id')->on('book_usuarios.ilhas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('interlocutors_ids')->nullable();
            $table->unsignedBigInteger('speaker_id');
            $table->foreign('speaker_id')->references('id')->on('book_usuarios.users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('groups');
    }
}
