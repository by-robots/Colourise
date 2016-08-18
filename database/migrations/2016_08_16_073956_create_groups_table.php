<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the groups table
        Schema::create('groups', function ($t) {
            $t->increments('id');
            $t->string('name');
            $t->string('archive')->nullable();
            $t->timestamps();
        });

        // Add the foreign key to the colourisations table
        Schema::table('colourisations', function ($t) {
            $t->integer('group_id')->unsigned()->nullable();

            $t->foreign('group_id')->references('id')->on('groups')
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
        Schema::table('colourisations', function ($t) {
            $t->dropForeign('colourisations_group_id_foreign');
        });

        Schema::drop('groups');
    }
}
