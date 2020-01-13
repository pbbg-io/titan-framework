<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterItemCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_categories', function (Blueprint $blueprint) {
            $blueprint->unsignedBigInteger('parent_id')->nullable();

            $blueprint->foreign('parent_id')
                ->references('id')
                ->on('item_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_categories', function (Blueprint $blueprint) {
            $blueprint->dropForeign('parent_id');
            $blueprint->dropColumn('parent_id');
        });
    }
}
