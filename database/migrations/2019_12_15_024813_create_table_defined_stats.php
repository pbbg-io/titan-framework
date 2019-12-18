<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDefinedStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defined_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('stat')->index();
            $table->text('description')->nullable();
            $table->string('type');
            $table->string('default');
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
        Schema::dropIfExists('defined_stats');
    }
}
