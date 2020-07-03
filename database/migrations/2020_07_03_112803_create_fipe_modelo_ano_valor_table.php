<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFipeModeloAnoValorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fipe_modelo_ano_valor', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('referencia_id')->nullable();
            $table->integer('tipo_id')->nullable();
            $table->integer('marca_id')->nullable();
            $table->integer('modelo_basico_id')->nullable();
            $table->integer('ano_modelo')->nullable();
            $table->integer('combustivel_id')->nullable();
            $table->string('modelo_cod_fipe')->nullable();
            $table->decimal('valor', 15)->nullable();
            $table->index(['referencia_id', 'modelo_cod_fipe'], 'fipe_modelo_ano_valor_referencia_id_modelo_cod_fipe_idx');
            $table->index(['referencia_id', 'tipo_id', 'marca_id', 'modelo_basico_id', 'ano_modelo', 'combustivel_id'], 'fipe_modelo_ano_valor_referencia_id_tipo_id_marca_id_modelo_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fipe_modelo_ano_valor');
    }
}
