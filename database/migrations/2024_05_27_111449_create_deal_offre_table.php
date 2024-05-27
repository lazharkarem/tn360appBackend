<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDealOffreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the deal_offre table
        Schema::create('deal_offre', function (Blueprint $table) {
            $table->id('ID_deal_offre');
            $table->unsignedBigInteger('ID_client');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->enum('statut', ['en_cours', 'cloturee', 'suspendu'])->default('en_cours');
            $table->enum('canal', ['site_web', 'mobile', 'magasin', 'list_magasins', 'enseigne']);
            $table->enum('type_offre', ['deal_depense', 'deal_marque', 'deal_diver', 'deal_frequence', 'deal_anniversaire']);
            $table->foreign('ID_client')->references('ID_client')->on('client')->onDelete('cascade');
            $table->timestamps();
        });

        // Create the offre_statut table
        Schema::create('offre_statut', function (Blueprint $table) {
            $table->id('ID_statut');
            $table->string('statut')->unique();
        });

        // Create the offre_canal table
        Schema::create('offre_canal', function (Blueprint $table) {
            $table->id('ID_canal');
            $table->string('canal')->unique();
        });

        // Create the offre_typeoffre table
        Schema::create('offre_typeoffre', function (Blueprint $table) {
            $table->id('ID_type_offre');
            $table->string('type_offre')->unique();
        });

        // Insert enum values into respective tables
        DB::table('offre_statut')->insert([
            ['statut' => 'en_cours'],
            ['statut' => 'cloturee'],
            ['statut' => 'suspendu'],
        ]);

        DB::table('offre_canal')->insert([
            ['canal' => 'site_web'],
            ['canal' => 'mobile'],
            ['canal' => 'magasin'],
            ['canal' => 'list_magasins'],
            ['canal' => 'enseigne'],
        ]);

        DB::table('offre_typeoffre')->insert([
            ['type_offre' => 'deal_depense'],
            ['type_offre' => 'deal_marque'],
            ['type_offre' => 'deal_diver'],
            ['type_offre' => 'deal_frequence'],
            ['type_offre' => 'deal_anniversaire'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deal_offre');
        Schema::dropIfExists('offre_statut');
        Schema::dropIfExists('offre_canal');
        Schema::dropIfExists('offre_typeoffre');
    }
}
