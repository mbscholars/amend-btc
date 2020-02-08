<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateTradeMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('trade_id');
            $table->string('reference');//wallet reference for checking and making payments. Only generated when payment is made
            $table->double('quantity');
            $table->double('price');
            $table->double('fee');
            $table->integer('status'); //0-pending, 1-completed, 2- dispute, 3- trashed,
            $table->string('pop');//proof of payment
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
        Schema::dropIfExists('trade_meta');
    }
}
