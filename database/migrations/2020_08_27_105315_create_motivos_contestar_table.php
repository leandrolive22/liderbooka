<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotivosContestarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bookmonitoria')->create('motivos_contestar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',100);
            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('book_usuarios.users')->onUpdate('no action')->onDelete('no action');
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
        Schema::dropIfExists('motivos_contestar');
    }
}
