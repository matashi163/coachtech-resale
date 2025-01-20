<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'status' => '良好',
            ],[
                'status' => '目立った傷や汚れなし',
            ],[
                'status' => 'やや傷や汚れあり',
            ],[
                'status' => '状態が悪い',
            ],
        ];

        Status::insert($statuses);
    }
}
