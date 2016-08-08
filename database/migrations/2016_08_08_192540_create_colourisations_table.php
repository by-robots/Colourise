<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColourisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colourisations', function ($t) {
            $t->increments('id');
            $t->integer('user_id')->unsigned();
            $t->string('title');
            $t->string('original');
            $t->string('colourised')->nullable()->default(null);
            $t->timestamps();

            $t->foreign('user_id')->references('id')->on('users')
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
            $t->dropForeign('colourisations_user_id_foreign');
        });

        Schema::drop('colourisations');
    }
}
