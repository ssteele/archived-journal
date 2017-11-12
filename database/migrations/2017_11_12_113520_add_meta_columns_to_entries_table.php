<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMetaColumnsToEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->text('feelings')->after('entry');
            $table->text('health')->after('feelings');
            $table->text('milestones')->after('health');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->dropColumn('health');
            $table->dropColumn('feelings');
            $table->dropColumn('milestones');
        });
    }
}
