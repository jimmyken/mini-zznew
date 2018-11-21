<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname',20);
            $table->unsignedInteger('gender');
            $table->string('language',10);
            $table->string('city',20);
            $table->string('province',20);
            $table->string('country',20);
            $table->string('avatarurl',255);
            $table->timestamp('birthday')->nullable();
            $table->string('mobile',22)->nullable();
            $table->index('nickname');
            $table->index('gender');
            $table->index('mobile');
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
        Schema::dropIfExists('users');
    }
}
