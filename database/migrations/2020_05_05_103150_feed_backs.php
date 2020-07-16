<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Connection;

class FeedBacks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'bookmonitoria';

    public function up()
    {
        Schema::connection($this->connection)->create('feedbacks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('monitoria_id');
            $table->foreign('monitoria_id')->references('id')->on('monitorias')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('book_usuarios.users')->onDelete('no action')->onUpdate('no action');
            $table->string('hash_feedback');
            $table->string('termo_concordancia');
            $table->string('supervisor_feedback');
            $table->string('operador_feedback');
            $table->float('media',5,2);
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
        Schema::dropIfExists('feedbacks');
    }
}
