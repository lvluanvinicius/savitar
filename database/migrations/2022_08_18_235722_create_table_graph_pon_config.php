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
        Schema::create('graph_pon_config', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("ID_OLT_GRAPH");

            $table->string("PORT")->nullable(false);
            $table->string("NAME_GRAPH")->nullable(false);

            $table->timestamps();

            $table->foreign("ID_OLT_GRAPH")->references("id")->on("olt_config")->onDelete("CASCADE");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('graph_pon_config');
    }
};
