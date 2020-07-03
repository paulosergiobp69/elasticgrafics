<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFipeCotacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fipe_cotacao', function (Blueprint $table) {
            $table->integer('cotacao_id')->nullable();
            $table->text('ano_modelo_desc');
            $table->text('modelo_cod_fipe');
            $table->integer('ref_id');
            $table->integer('combustivel_id');
            $table->decimal('ano_modelo', 10, 0)->nullable();
            $table->date('cotacao_dtinclusao')->nullable();
            $table->decimal('cotacao_valor', 10, 0);
            $table->integer('id', true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fipe_cotacao');
    }
}
