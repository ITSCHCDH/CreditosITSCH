<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableReceptores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receptores', function(Blueprint $table){
            $table->increments('id');
            $table->integer('mensaje_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->enum('visto',['true','false']);
            $table->dateTime('fecha_visto')->nullable();
            $table->timestamps();
            $table->foreign('mensaje_id')->references('id')->on('mensajes')->ondelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receptores');
    }
}
