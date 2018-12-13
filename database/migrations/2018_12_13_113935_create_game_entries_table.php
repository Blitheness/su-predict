<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('twitter_id', 255);
            $table->string('outcome_1', 64);
            $table->unsignedInteger('outcome_1_value');
            $table->string('outcome_2');
            $table->unsignedInteger('outcome_2_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_entries');
    }
}
