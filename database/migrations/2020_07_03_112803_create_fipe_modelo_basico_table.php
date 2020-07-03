<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFipeModeloBasicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fipe_modelo_basico', function (Blueprint $table) {
            $table->integer('id')->primary('fipe_modelo_basico_pkey');
            $table->integer('marca_id')->nullable();
            $table->integer('tipo_id')->nullable();
            $table->string('modelo_desc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fipe_modelo_basico');
    }
}
