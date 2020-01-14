<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateSocialLogins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_providers', function (Blueprint $blueprint) {
            $blueprint->increments('id');
            $blueprint->unsignedBigInteger('user_id');
            $blueprint->string('provider',60);
            $blueprint->string('providerId');
            $blueprint->string('avatar')->nullable();

            $blueprint->timestamps();

            $blueprint->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('social_providers');
    }
}
