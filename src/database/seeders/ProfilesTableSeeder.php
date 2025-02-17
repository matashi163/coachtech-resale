<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profiles = [
            [
                'user_id' => '1',
                'image' => 'banana.png',
                'name' => '一郎',
                'zip_code' => '1111111',
                'adress' => '住所1',
            ],[
                'user_id' => '2',
                'image' => 'grapes.png',
                'name' => '二郎',
                'zip_code' => '2222222',
                'adress' => '住所2',
            ],[
                'user_id' => '3',
                'image' => 'kiwi.png',
                'name' => '三郎',
                'zip_code' => '3333333',
                'adress' => '住所3',
            ],[
                'user_id' => '4',
                'image' => 'melon.png',
                'name' => '四郎',
                'zip_code' => '4444444',
                'adress' => '住所4',
            ],[
                'user_id' => '5',
                'image' => 'muscat.png',
                'name' => '五郎',
                'zip_code' => '5555555',
                'adress' => '住所5',
            ],
        ];

        Profile::insert($profiles);
    }
}
