<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCagnotteRetraitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('cagnotte_retrait', function (Blueprint $table) {
        $table->bigIncrements('ID_retrait');
        $table->bigInteger('order_id')->nullable(); // Change to bigInteger (signed) to match `orders.id`
        $table->unsignedBigInteger('ID_client');
        $table->decimal('amount_retrait', 10, 2);
        $table->timestamps();

        // Foreign key constraints
        $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
        $table->foreign('ID_client')->references('ID_client')->on('client')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the 'cagnotte_retrait' table
        Schema::dropIfExists('cagnotte_retrait');
    }
}
