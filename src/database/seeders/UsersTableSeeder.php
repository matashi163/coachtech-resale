<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => '一郎',
                'email' => 'ichiro@example',
                'password' => Hash::make('password'),
                'first_login' => false,
            ],[
                'name' => '二郎',
                'email' => 'jiro@example',
                'password' => Hash::make('password'),
                'first_login' => false,
            ],[
                'name' => '三郎',
                'email' => 'saburo@example',
                'password' => Hash::make('password'),
                'first_login' => false,
            ],[
                'name' => '四郎',
                'email' => 'shiro@example',
                'password' => Hash::make('password'),
                'first_login' => false,
            ],[
                'name' => '五郎',
                'email' => 'goro@example',
                'password' => Hash::make('password'),
                'first_login' => false,
            ],
        ];

        User::insert($users);
    }
}
