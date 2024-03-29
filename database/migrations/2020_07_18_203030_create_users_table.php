<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Database\Libs\BlueprintTrait;

class CreateUsersTable extends Migration
{
    use BlueprintTrait;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment('id');
            $table->string('user_id')->unique('UNQ_USER_ID')->comment('ユーザーID');
            $table->string('password')->comment('パスワード');
            $table->string('name')->comment('名前');
            $table->boolean('is_deleted')->comment('削除フラグ');
            $table->string('access_token')->comment('アクセストークン');
            $table->datetimes();
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
