<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id('uid');
            $table->string('uname',10)->unique();
            $table->string('fname',20);
            $table->string('lname',20);
            $table->string('email',50)->unique();
            $table->string('about',200)->nullable();
            $table->date('dob');
            $table->string('password',60);
            $table->enum('gender', ['M', 'F', 'O']);
            $table->integer('followers')->default(0);
            $table->integer('followings')->default(0);
            $table->timestamp('reg_date')->default(now());
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
