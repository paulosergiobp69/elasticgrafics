<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFipeModeloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fipe_modelo', function (Blueprint $table) {
            $table->text('modelo_cod_fipe')->nullable()->unique('fipe_modelo_modelo_cod_fipe_key');
            $table->integer('marca_id');
            $table->integer('tipo_id');
            $table->text('modelo_desc');
            $table->integer('id', true);
            $table->integer('modelo_basico_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fipe_modelo');
    }
}
