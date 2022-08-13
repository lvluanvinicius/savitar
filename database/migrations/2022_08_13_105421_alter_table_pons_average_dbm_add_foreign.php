<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** olt_config
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pons_average_dbm', function (Blueprint $table) {
            $table->unsignedBigInteger("ID_OLT");
            $table->foreign('ID_OLT')->references('id')->on('olt_config');
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
            Schema::dropColumns('ID_OLT');
        });
    }
};
