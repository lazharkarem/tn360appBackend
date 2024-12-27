<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('marques', function (Blueprint $table) {
        $table->id('id_marque'); // Primary key
        $table->string('nom_marque');
        $table->tinyInteger('statut')->default(1); // Active by default
        $table->string('image')->nullable();
        $table->string('addresse_marque')->nullable();
        $table->string('email_marque');
        $table->string('tel_marque')->nullable();
        $table->timestamps(); // created_at and updated_at
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marques');
    }
}
