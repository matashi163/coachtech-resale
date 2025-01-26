<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Condision;

class CondisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $condisions = [
            [
                'condision' => '良好',
            ],[
                'condision' => '目立った傷や汚れなし',
            ],[
                'condision' => 'やや傷や汚れあり',
            ],[
                'condision' => '状態が悪い',
            ],
        ];

        Condision::insert($condisions);
    }
}
