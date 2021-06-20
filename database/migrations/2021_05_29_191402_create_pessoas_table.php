<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePessoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pessoa');
            $table->foreign('id_pessoa')->references('id')->on('users');
            $table->unsignedBigInteger('id_evento');
            $table->foreign('id_evento')->references('id')->on('eventos');
            $table->enum('status', ['pendente', 'confirmado', 'recusado']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pessoas');
    }
}
