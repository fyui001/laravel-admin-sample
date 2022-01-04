<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Database\Libs\BlueprintTrait;

class CreateAdminUsersTable extends Migration
{
    use BlueprintTrait;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('id');
            $table->string('user_id')->unique('UNQ_ADMIN_USER_ID')->comment('管理者ID');
            $table->string('password')->comment('パスワード');
            $table->string('name')->comment('名前');
            $table->boolean('role')->default(0)->comment('ロール');
            $table->boolean('status')->default(1)->comment('ステータス');
            $this->dateTimes($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
