<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('item_category_id');
            $table->boolean('equippable')->default(false);
            $table->boolean('consumable')->default(false);
            $table->boolean('stackable')->default(false);
            $table->unsignedBigInteger('consumable_uses')->default(0);
            $table->boolean('buyable')->default(false);
            $table->unsignedBigInteger('cost')->nullable();
            $table->timestamps();

            $table->foreign('item_category_id')
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
        Schema::dropIfExists('items');
    }
}
