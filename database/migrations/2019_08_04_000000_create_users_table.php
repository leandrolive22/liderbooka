<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('matricula',8)->unique()->nullable();
            $table->string('name');
            $table->string('username');
            $table->string('password');
            $table->string('cpf',16);
            $table->integer('ddd',2)->nullable();
            $table->integer('phone',9)->nullable();
            $table->string('avatar');
            $table->string('css',8);
            $table->text('token')->nullable();
            $table->date('have_humour')->nullable();
            $table->timestamp('last_login');
            $table->unsignedBigInteger('cargo_id');
            $table->foreign('cargo_id')->references('id')->on('cargos')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('ilha_id');
            $table->foreign('ilha_id')->references('id')->on('ilhas')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('setor_id');
            $table->foreign('setor_id')->references('id')->on('setores')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('carteira_id');
            $table->foreign('carteira_id')->references('id')->on('carteiras')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('filial_id');
            $table->foreign('filial_id')->references('id')->on('filiais')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->unsignedBigInteger('coordenador_id')->nullable();
            $table->unsignedBigInteger('gerente_id')->nullable();
            $table->unsignedBigInteger('superintendente_id')->nullable();
            $table->timestamp('accept_lgpd')->nullable();
            $table->string('another_config')->nullable();
            $table->date('data_admissao')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
