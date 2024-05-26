<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealFrequenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('deal_frequence', function (Blueprint $table) {
            $table->id('ID_deal_frequence');
            $table->unsignedBigInteger('ID_client');
            $table->string('segments', 255);
            $table->decimal('panier_moyen', 10, 2);
            $table->decimal('objectif_frequence', 10, 2);
            $table->decimal('compteur_frequence', 10, 2);
            $table->decimal('gain', 10, 2);
            $table->decimal('commande_1', 10, 2);
            $table->decimal('commande_2', 10, 2);
            $table->decimal('commande_3', 10, 2);
            $table->decimal('commande_4', 10, 2);
            $table->decimal('commande_5', 10, 2);
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
        Schema::dropIfExists('deal_frequences');
    }
}
