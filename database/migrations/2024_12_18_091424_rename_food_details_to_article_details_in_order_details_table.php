<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameFoodDetailsToArticleDetailsInOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::table('order_details', function (Blueprint $table) {
        $table->renameColumn('food_details', 'article_details');
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
        $table->renameColumn('article_details', 'food_details');
    });
}
}
