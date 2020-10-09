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
            $table->unsignedBigInteger('monitor_id');
            $table->foreign('monitor_id')->references('id')->on('book_usuarios.users')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('operador_id');
            $table->foreign('operador_id')->references('id')->on('book_usuarios.users')->onDelete('no action')->onUpdate('no action');
            $table->unsignedBigInteger('supervisor_id');
            $table->foreign('supervisor_id')->references('id')->on('book_usuarios.users')->onDelete('no action')->onUpdate('no action');
            $table->text('usuario_cliente')->nullable();
            $table->unsignedBigInteger('produto');
            $table->foreign('produto')->references('id')->on('book_usuarios.ilhas')->onDelete('no action')->onUpdate('no action');
            $table->text('cliente')->nullable();
            $table->text('tipo_ligacao');
            $table->bigInteger('cpf_cliente')->nullable();
            $table->date('data_ligacao');
            $table->time('hora_ligacao');
            $table->text('id_audio')->nullable();
            $table->time('tempo_ligacao');
            $table->text('pontos_positivos')->nullable();
            $table->text('pontos_desenvolver')->nullable();
            $table->text('pontos_atencao')->nullable();
            $table->string('hash_monitoria')->index();
            $table->string('hash_operator')->nullable();
            $table->float('media',6,2)->index();
            $table->integer('conf');
            $table->integer('nConf');
            $table->integer('nAv');
            $table->integer('ncg');
            $table->string('quartil',3);
            $table->unsignedBigInteger('modelo_id');
            $table->foreign('modelo_id')->references('id')->on('laudos_modelos')->onDelete('no action')->onUpdate('no action');
            $table->text('feedback_monitor')->nullable();
            $table->text('feedback_supervisor')->nullable();
            $table->text('feedback_operador')->nullable();
            $table->integer('resp_operador')->nullable();
            $table->timestamp('operador_at')->nullable();
            $table->timestamp('supervisor_at')->nullable();
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
        Schema::dropIfExists('monitorias');
    }
}
