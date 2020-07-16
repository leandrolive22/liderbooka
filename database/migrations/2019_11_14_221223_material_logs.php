<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Connection;

class MaterialLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bookrelatorios')->create('material_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('action');
            $table->unsignedBigInteger('material_id')->nullable();
            $table->foreign('material_id')->references('id')->on('book_materiais.materiais')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('video_id')->nullable();
            $table->foreign('video_id')->references('id')->on('book_materiais.videos')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('calculadora_id')->nullable();
            $table->foreign('calculadora_id')->references('id')->on('book_materiais.calculadoras')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('circular_id')->nullable();
            $table->foreign('circular_id')->references('id')->on('book_materiais.circulares')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('roteiro_id')->nullable();
            $table->foreign('roteiro_id')->references('id')->on('book_materiais.roteiros')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('post_id')->nullable();
            $table->foreign('post_id')->references('id')->on('book_posts.posts')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('ilha_id');
            $table->foreign('ilha_id')->references('id')->on('book_usuarios.ilhas')->onDelete('no action')->onUpdate('no action');
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
