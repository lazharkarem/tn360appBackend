<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Marques extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('marques', function (Blueprint $table) {
            $table->bigIncrements('idMarque');
            $table->string('nomMarque');
            $table->string('logo')->nullable();
            $table->string('teleMarque')->nullable();
            $table->string('emailMarque');
            $table->string('contrat')->nullable();
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
         Schema::dropIfExists('marques');
    }
}
