<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pons_average_dbm', function (Blueprint $table) {
            $table->integer("COLLECTION_DATE");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pons_average_dbm', function (Blueprint $table) {
            $table->dropColumn('COLLECTION_DATE');
        });
    }
};
