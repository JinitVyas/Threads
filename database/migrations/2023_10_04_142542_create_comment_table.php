<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment', function (Blueprint $table) {
            $table->id('cid');
            $table->unsignedBigInteger('uid');
            $table->unsignedBigInteger('tid');
            $table->string('ctext',400);
            $table->timestamp('cdatetime')->default(now());

            $table->foreign('uid')->references('uid')->on('users');
            $table->foreign('tid')->references('tid')->on('thread');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment');
    }
}
