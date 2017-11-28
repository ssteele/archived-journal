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
            $table->text('tag')->after('entry');
            $table->text('mention')->after('tag');
            $table->text('feeling')->after('mention');
            $table->text('health')->after('feeling');
            $table->text('milestone')->after('health');
            $table->text('idea')->after('milestone');
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
            $table->dropColumn('tag');
            $table->dropColumn('mention');
            $table->dropColumn('feeling');
            $table->dropColumn('health');
            $table->dropColumn('milestone');
            $table->dropColumn('idea');
        });
    }
}
