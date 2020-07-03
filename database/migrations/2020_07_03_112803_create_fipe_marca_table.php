<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFipeMarcaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fipe_marca', function (Blueprint $table) {
            $table->integer('marca_id')->primary('fipe_marca_pkey');
            $table->text('marca_desc');
            $table->integer('rm_marc_cod')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fipe_marca');
    }
}
