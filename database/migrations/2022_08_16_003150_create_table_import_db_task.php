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
        Schema::create('import_db_task', function (Blueprint $table) {
            $table->id();

            $table->string("name_file")->nullable(false);
            $table->string("path")->nullable(false);

            $table->boolean("finished")->default(0);

            $table->unsignedBigInteger("id_user");

            $table->timestamps();


            $table->foreign("id_user")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('import_db_task');
    }
};
