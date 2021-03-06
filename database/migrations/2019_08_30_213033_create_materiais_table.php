<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Connection;


class CreateMateriaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'bookmateriais';

    public function up()
    {
        Schema::connection('bookmateriais')->create('materiais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('file_path');
            $table->string('sub_local_id')->nullable();
            $table->text('ilha_id');
            $table->text('sector');
            $table->text('tags');
            $table->unsignedInteger('view_number')->nullable();
            $table->text('cargo_id')->nullalbe();
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
        Schema::dropIfExists('materiais');
    }
}
