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
        Schema::create('users_groups_related', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_group_users');

            $table->foreign('id_group_users')->references('id')->on('group_users');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_groups_related');
    }
};
