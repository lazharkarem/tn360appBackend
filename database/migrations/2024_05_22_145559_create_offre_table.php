<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
     {
        Schema::create('offre', function (Blueprint $table) {
            $table->id('ID_offre');
            $table->unsignedBigInteger('ID_client');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->enum('statut', ['en_cours', 'cloturee', 'suspendu'])->default('en_cours');
            $table->enum('canal', ['site_web', 'mobile', 'magasin', 'list_magasins', 'enseigne']);
            $table->enum('type_offre', ['deal_comportement', 'deal_marques', 'deal_divers']);
            $table->foreign('ID_client')->references('ID_client')->on('client');
            $table->foreign('statut')->references('statut')->on('offre_statut');
            $table->foreign('canal')->references('canal')->on('offre_canal');
            $table->foreign('type_offre')->references('type_offre')->on('offre_typeoffre');
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
        Schema::dropIfExists('offre');
    }
}
