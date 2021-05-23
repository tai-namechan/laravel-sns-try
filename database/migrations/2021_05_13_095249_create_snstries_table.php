<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSnstriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snstries', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string('body');

            // ユーザーI'dのカラムを作るもの
            $table->unsignedBigInteger('user_id');
            // foreign外部の
            // 外部のテーブルと連携するためのカラムのuser＿id
            $table->foreign('user_id')->references('id')->on('users');

            // posts.user_id = users.id 一致させる

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
        Schema::dropIfExists('snstries');
    }
}
