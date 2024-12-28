<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMarquesAndArticlesTables extends Migration
{
    public function up()
    {
        // Ensure the id_marque column exists and is properly defined in marques
        Schema::table('marques', function (Blueprint $table) {
            $table->bigIncrements('id_marque')->change();
        });

        // Update articles table to fix the foreign key constraint
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('marque_id')->nullable()->change(); // Ensure marque_id is unsigned and nullable

            // Drop and recreate the foreign key
            $table->dropForeign(['marque_id']); // Drop existing foreign key if any
            $table->foreign('marque_id')
                  ->references('id_marque')
                  ->on('marques')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        // Reverse the changes
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['marque_id']);
        });
    }
}
