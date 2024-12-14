<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id('id_contract');
            $table->unsignedBigInteger('id_structure');
            $table->unsignedBigInteger('id_fournisseur');
            $table->String('ref');
            $table->Date('date_acquisition');
            $table->Date('garantie');
            $table->String('Type_contract');
            $table->timestamps();


            $table->foreign('id_structure')->references('id_structure')->on('structures')->onDelete('cascade');
            $table->foreign('id_fournisseur')->references('id_fournisseur')->on('providers')->onDelete('cascade');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
