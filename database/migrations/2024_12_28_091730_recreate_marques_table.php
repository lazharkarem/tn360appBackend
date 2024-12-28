<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateMarquesTable extends Migration
{
    public function up()
    {
        // Recreate the 'marques' table
        Schema::create('marques', function (Blueprint $table) {
            $table->bigIncrements('id_marque')->unsigned(); // PRIMARY KEY
            $table->string('nom_marque');
            $table->tinyInteger('statut')->default(1); // Active by default
            $table->string('image')->nullable();
            $table->string('addresse_marque')->nullable();
            $table->string('email_marque');
            $table->string('tel_marque')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        // Drop the 'marques' table if needed
        Schema::dropIfExists('marques');
    }
}
