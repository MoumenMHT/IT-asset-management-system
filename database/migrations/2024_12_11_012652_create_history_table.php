<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id('id_history');
            $table->unsignedBigInteger('id_equipement');
            $table->unsignedBigInteger('id_employer');
            $table->String('type');
            $table->String('status');
            $table->String('path');
            $table->timestamps();


            $table->foreign('id_equipement')->references('id_equipement')->on('equipment')->onDelete('cascade');
            $table->foreign('id_employer')->references('id_employer')->on('employers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history');
    }
}
