<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('sex',1)->nullable();
            $table->string('state')->nullable();
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('phone_3')->nullable();
            $table->string('phone_4')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('language')->default('english');
            $table->string('passport')->default('images/passport/avatar.png');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('user_code')->nullable();
            $table->integer('addresses')->default(0);
            $table->boolean('security')->default('0');
            $table->integer('rating')->default(0);
            $table->integer('rating_count')->default(0);
            $table->decimal('avg_rating')->default(0);
            $table->integer('views')->default(0);
            $table->integer('trades')->default(0);
            $table->boolean('working')->default(1);
            $table->integer('last_online')->default(0);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
