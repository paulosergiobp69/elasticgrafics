<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFipeModeloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fipe_modelo', function (Blueprint $table) {
            $table->foreign('tipo_id', 'fipe_modelo_tipo_id_fkey')->references('tipo_id')->on('fipe_veic_tipo')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('marca_id', 'fipe_modelo_marca_id_fkey')->references('marca_id')->on('fipe_marca')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('tipo_id', 'fipe_modelo_tipo_id_fkey1')->references('tipo_id')->on('fipe_veic_tipo')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('marca_id', 'fipe_modelo_marca_id_fkey1')->references('marca_id')->on('fipe_marca')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('marca_id', 'fipe_modelo_marca_id_fkey2')->references('marca_id')->on('fipe_marca')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fipe_modelo', function (Blueprint $table) {
            $table->dropForeign('fipe_modelo_tipo_id_fkey');
            $table->dropForeign('fipe_modelo_marca_id_fkey');
            $table->dropForeign('fipe_modelo_tipo_id_fkey1');
            $table->dropForeign('fipe_modelo_marca_id_fkey1');
            $table->dropForeign('fipe_modelo_marca_id_fkey2');
        });
    }
}
