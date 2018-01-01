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
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('name', 64);
            $table->timestamps();
        });

        Schema::create('mentions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('name', 64);
            $table->timestamps();
        });

        Schema::create('marker_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('name', 64);
            $table->string('shorthand', 1)->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        Schema::create('markers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('marker_category_id')->unsigned();
            $table->foreign('marker_category_id')
                ->references('id')
                ->on('marker_categories')
                ->onDelete('cascade');
            $table->integer('entry_id')->unsigned();
            $table->foreign('entry_id')
                ->references('id')
                ->on('entries')
                ->onDelete('cascade');
            $table->text('marker');
            $table->timestamps();
        });

        Schema::create('entry_has_tags', function (Blueprint $table) {
            $table->integer('entry_id')->unsigned();
            $table->foreign('entry_id')
                ->references('id')
                ->on('entries')
                ->onDelete('cascade');
            $table->integer('tag_id')->unsigned();
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('cascade');
        });

        Schema::create('entry_has_mentions', function (Blueprint $table) {
            $table->integer('entry_id')->unsigned();
            $table->foreign('entry_id')
                ->references('id')
                ->on('entries')
                ->onDelete('cascade');
            $table->integer('mention_id')->unsigned();
            $table->foreign('mention_id')
                ->references('id')
                ->on('mentions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('entry_has_tags');
        Schema::drop('entry_has_mentions');
        Schema::drop('tags');
        Schema::drop('mentions');
        Schema::drop('markers');
        Schema::drop('marker_categories');
    }
}
