<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCagnotteDepotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('cagnotte_depot', function (Blueprint $table) {
        $table->bigIncrements('ID_depot');
        $table->unsignedBigInteger('ID_client');
        $table->unsignedBigInteger('ID_deal_offre')->nullable(); // Deal reference, optional
        $table->decimal('amount_depot', 10, 2);
        $table->timestamps();

        // Foreign keys
        $table->foreign('ID_client')->references('ID_client')->on('client')->onDelete('cascade');
        $table->foreign('ID_deal_offre')->references('ID_deal_offre')->on('deal_offre')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cagnotte_depot');
    }
}
