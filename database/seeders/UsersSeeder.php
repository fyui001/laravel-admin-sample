<?php

declare(strict_types=1);

namespace Database\Seeders;

use Domain\Base\BaseBooleanValue;
use Domain\Common\CreatedAt;
use Domain\Common\UpdatedAt;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_id' => 'matsui_eriko',
            'password' => Hash::make('hogehoge'),
            'name' => '松井恵理子',
            'access_token' => '',
            'is_deleted' => BaseBooleanValue::FALSE,
            'created_at' => CreatedAt::now()->getSqlTimeStamp(),
            'updated_at' => UpdatedAt::now()->getSqlTimeStamp(),
        ]);
    }
}
