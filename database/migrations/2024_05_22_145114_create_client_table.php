<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
   {
        Schema::create('client', function (Blueprint $table) {

            $table->id('ID_client');
            $table->string('email', 255);
            $table->string('civilite', 50)->nullable();
            $table->date('date_de_naissance1')->nullable();
            $table->date('date_de_naissance2')->nullable();
            $table->date('date_de_naissance3')->nullable();
            $table->date('date_de_naissance4')->nullable();
            $table->string('address', 255)->nullable();
            $table->date('date_de_naissance')->nullable();
            $table->tinyInteger('statut')->default(0);
            $table->string('code_postal', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('nom_enfant_1', 255)->nullable();
            $table->string('nom_enfant_2', 255)->nullable();
            $table->string('nom_enfant_3', 255)->nullable();
            $table->string('nom_enfant_4', 255)->nullable();
            $table->string('nom_et_prenom', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('profession', 255)->nullable();
            $table->string('situation_familiale', 255)->nullable();
            $table->string('tel', 20)->nullable();
            $table->string('verification_code', 255)->nullable();
            $table->string('ville', 255)->nullable();
            $table->string('gouvernorat', 255)->nullable();
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
        Schema::dropIfExists('client');
    }
}
