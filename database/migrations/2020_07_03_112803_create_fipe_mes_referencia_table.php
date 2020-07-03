<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFipeMesReferenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fipe_mes_referencia', function (Blueprint $table) {
            $table->integer('ref_id')->primary('fipe_mes_referencia_pkey');
            $table->date('ref_date');
            $table->text('ref_desc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fipe_mes_referencia');
    }
}
