<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToArticles extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            // Add foreign key if 'marque_id' column exists
            if (Schema::hasColumn('articles', 'marque_id')) {
                $table->foreign('marque_id')->references('id_marque')->on('marques')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['marque_id']);
        });
    }
}
