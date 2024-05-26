<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealDiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_divers', function (Blueprint $table) {
            $table->id('ID_deal_divers');
            $table->unsignedBigInteger('ID_client');
            $table->decimal('objectif', 10, 2);
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
        Schema::dropIfExists('deal_divers');
    }
}
