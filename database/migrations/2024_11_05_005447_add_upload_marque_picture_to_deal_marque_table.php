<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUploadMarquePictureToDealMarqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deal_marque', function (Blueprint $table) {
            $table->string('upload_marque_picture', 255)->nullable()->after('code_marque');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deal_marque', function (Blueprint $table) {
            $table->dropColumn('upload_marque_picture');
        });
    }
}
