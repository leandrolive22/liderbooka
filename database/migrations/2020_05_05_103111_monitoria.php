<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Connection;

class Monitoria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'bookmonitoria';

    public function up()
    {
        Schema::connection($this->connection)->create('monitorias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('file_path');
            $table->unsignedBigInteger('monitor_id');
            $table->foreign('monitor_id')->references('id')->on('book_usuarios.users')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('operador_id');
            $table->foreign('operador_id')->references('id')->on('book_usuarios.users')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('supervisor_id');
            $table->foreign('supervisor_id')->references('id')->on('book_usuarios.users')->onDelete('no action')->onUpdate('no action');
            $table->string('usuario_cliente');
            $table->string('produto');
            $table->string('cliente');
            $table->string('tipo_ligacao');
            $table->bigInteger('cpf_cliente');
            $table->date('data_ligacao');
            $table->time('hora_ligacao');
            $table->text('id_audio');
            $table->time('tempo_ligacao');
            $table->unsignedInteger('pontos_positivos');
            $table->unsignedInteger('pontos_desenvolver');
            $table->unsignedInteger('pontos_atencao');
            $table->string('hash_monitoria');
            $table->text('monitor_feedback');
            $table->unsignedBigInteger('modelo_id');
            $table->foreign('modelo_id')->references('id')->on('laudos_modelos')->onDelete('no action')->onUpdate('no action');
            $table->text('itens_id');
            $table->unsignedBigInteger('feedback_supervisor');
            $table->unsignedBigInteger('feedback_operador');
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
        Schema::dropIfExists('roteiros');
    }
}
