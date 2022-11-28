<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableCreditos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',70);
            $table->integer("credito_jefe")->nullable()->unsigned();
            $table->enum("vigente",["true","false"])->default("true");
            $table->foreign("credito_jefe")->references("id")->on("users")->onDelete("cascade");
            $table->timestamps();
        });

        Schema::create('creditos_areas', function(Blueprint $table){
            $table->increments('id');
            $table->integer('credito_id')->unsigned();
            $table->integer('credito_area')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('creditos_areas');
        Schema::dropIfExists('creditos');
    }
}
