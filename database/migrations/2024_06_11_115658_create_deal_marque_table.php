<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealMarqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
     {
        Schema::create('deal_marque', function (Blueprint $table) {
            $table->id('ID_deal_marque');
            $table->unsignedBigInteger('ID_client');
            $table->string('segments', 255);
            $table->string('code_marque', 255);
            $table->decimal('objectif_1', 10, 2);
            $table->decimal('objectif_2', 10, 2);
            $table->decimal('objectif_3', 10, 2);
            $table->decimal('objectif_4', 10, 2);
            $table->decimal('objectif_5', 10, 2);
            $table->decimal('gain_objectif_1', 10, 2);
            $table->decimal('gain_objectif_2', 10, 2);
            $table->decimal('gain_objectif_3', 10, 2);
            $table->decimal('gain_objectif_4', 10, 2);
            $table->decimal('gain_objectif_5', 10, 2);
            $table->decimal('compteur_objectif',10,2);
            $table->foreign('ID_client')->references('ID_client')->on('client');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deal_marque');
    }
}
