<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveEntryOptionsToOwnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_entries', function (Blueprint $t) {
            $t->dropColumn('outcome_1');
            $t->dropColumn('outcome_1_value');
            $t->dropColumn('outcome_2');
            $t->dropColumn('outcome_2_value');
        });
        Schema::create('entry_options', function(Blueprint $t) {
            $t->increments('id');
            $t->unsignedInteger('game_entry_id');
            $t->string('outcome', 64);
            $t->unsignedInteger('value');
        });
        Schema::table('entry_options', function(Blueprint $t) {
            $t->foreign('game_entry_id')->references('id')->on('game_entries')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entry_options');
        Schema::table('game_entries', function (Blueprint $t) {
            $t->string('outcome_1', 64);
            $t->unsignedInteger('outcome_1_value');
            $t->string('outcome_2', 64);
            $t->unsignedInteger('outcome_2_value');
        });
    }
}
