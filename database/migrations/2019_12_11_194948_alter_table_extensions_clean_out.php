<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableExtensionsCleanOut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('extensions', function(Blueprint $blueprint) {
            $blueprint->dropColumn('author');
            $blueprint->dropColumn('url');
            $blueprint->dropColumn('version');
            $blueprint->dropColumn('name');
            $blueprint->string('namespace');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('extensions', function(Blueprint $blueprint) {
            $blueprint->string('name');
            $blueprint->string('author');
            $blueprint->string('url')->nullable();
            $blueprint->string('version')->default('0.0.1');
        });
    }
}
