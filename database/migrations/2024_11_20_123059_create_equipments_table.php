<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id('id_equipement');
            $table->unsignedBigInteger('id_contract');
            $table->unsignedBigInteger('id_employer');
            $table->String('Type');
            $table->String('num_serie');
            $table->String('marque');
            $table->String('etat');
            $table->String('status');
            $table->date('date_amortissement');     
            $table->timestamps();


            // Foreign key constraint
            $table->foreign('id_contract')->references('id_contract')->on('contracts')->onDelete('cascade');
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
        Schema::dropIfExists('equipment');
    }
}
