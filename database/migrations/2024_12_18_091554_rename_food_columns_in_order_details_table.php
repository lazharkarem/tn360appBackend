<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameFoodColumnsInOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::table('order_details', function (Blueprint $table) {
        // Rename the columns
        $table->renameColumn('food_id', 'article_id'); // Renaming food_id to article_id
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
   public function down()
{
    Schema::table('order_details', function (Blueprint $table) {
        // Revert the column names back to original names
        $table->renameColumn('article_id', 'food_id');
    });
}
}
