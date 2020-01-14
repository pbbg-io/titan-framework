<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersAddLastChosen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $blueprint) {
            $blueprint->unsignedBigInteger('last_character_played')->nullable();

            $blueprint->foreign('last_character_played')
                ->references('id')
                ->on('characters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $blueprint){
            $blueprint->dropForeign('last_character_played');
            $blueprint->dropColumn('last_character_played');
        });
    }
}
