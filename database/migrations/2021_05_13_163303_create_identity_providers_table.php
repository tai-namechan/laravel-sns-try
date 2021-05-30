<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdentityProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identity_providers', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            // usersテーブルのuser＿idにidentity＿providersにidを紐づけて管理したいためしたのように
            $table->foreign('user_id')->references('id')->on('users'); // 外部キー制約をする
            $table->string('provider_id');
            $table->string('provider_name');
            $table->primary(['provider_name', 'provider_id']); // 複合キー
            $table->unique(['user_id', 'provider_name']); // ユニーク制限
            $table->string('password')->nullable(); // nullable()を追加
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
        Schema::dropIfExists('identity_providers');
    }
}
