<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFipeModeloAnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fipe_modelo_ano', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('tipo_id')->nullable();
            $table->integer('marca_id')->nullable();
            $table->integer('modelo_basico_id')->nullable();
            $table->string('modelo_ano_desc')->nullable();
            $table->string('modelo_ano_id', 32)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fipe_modelo_ano');
    }
}
