<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
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
                'name' => '腕時計',
                'image' => 'watch.jpg',
                'price' => '15000',
                'description' => 'スタイリッシュなデザインのメンズ時計',
                'condision_id' => '1',
            ],[
                'name' => 'HDD',
                'image' => 'HDD.jpg',
                'price' => '5000',
                'description' => '高速で信頼性の高いハードディスク',
                'condision_id' => '2',
            ],[
                'name' => '玉ねぎ3束',
                'image' => 'onion.jpg',
                'price' => '300',
                'description' => '新鮮な玉ねぎ3束のセット',
                'condision_id' => '3',
            ],[
                'name' => '革靴',
                'image' => 'leather_shoes.jpg',
                'price' => '4000',
                'description' => 'クラシックなデザインの革靴',
                'condision_id' => '4',
            ],[
                'name' => 'ノートPC',
                'image' => 'laptop.jpg',
                'price' => '45000',
                'description' => '高性能なノートパソコン',
                'condision_id' => '1',
            ],[
                'name' => 'マイク',
                'image' => 'mic.jpg',
                'price' => '8000',
                'description' => '高品質のレコーディング用マイク',
                'condision_id' => '2',
            ],[
                'name' => 'ショルダーバッグ',
                'image' => 'shoulder_bag.jpg',
                'price' => '3500',
                'description' => 'おしゃれなショルダーバッグ',
                'condision_id' => '3',
            ],[
                'name' => 'タンブラー',
                'image' => 'tumbler.jpg',
                'price' => '500',
                'description' => '使いやすいタンブラー',
                'condision_id' => '4',
            ],[
                'name' => 'コーヒーミル',
                'image' => 'coffee_grinder.jpg',
                'price' => '4000',
                'description' => '手動のコーヒーミル',
                'condision_id' => '1',
            ],[
                'name' => 'メイクセット',
                'image' => 'makeup_set.jpg',
                'price' => '2500',
                'description' => '便利なメイクアップセット',
                'condision_id' => '2',
            ],
        ];

        Product::insert($users);
    }
}
