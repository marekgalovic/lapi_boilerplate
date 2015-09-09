<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokens', function(Blueprint $t)
        {
            $t->increments( 'id' );

            $t->string( 'token' );
            $t->timestamp( 'expires' );

            $t->integer( 'user_id' )->unsigned();
            $t->foreign( 'user_id' )->references( 'id' )->on( 'users' );

            $t->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tokens');
    }
}
