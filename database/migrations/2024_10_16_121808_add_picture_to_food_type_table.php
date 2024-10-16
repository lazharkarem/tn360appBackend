<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPictureToFoodTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('food_types', function (Blueprint $table) {
            $table->string('picture')->nullable()->after('title'); // Adds a nullable 'picture' column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('food_type', function (Blueprint $table) {
            $table->dropColumn('picture'); // Removes the 'picture' column if rolled back
        });
    }
}
