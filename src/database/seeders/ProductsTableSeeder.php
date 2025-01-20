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
                'image' => '',
                'price' => '15000',
                'description' => 'スタイリッシュなデザインのメンズ時計',
                'status_id' => '1',
            ],[
                'name' => 'HDD',
                'image' => '',
                'price' => '5000',
                'description' => '高速で信頼性の高いハードディスク',
                'status_id' => '2',
            ],[
                'name' => '玉ねぎ3束',
                'image' => '',
                'price' => '300',
                'description' => '新鮮な玉ねぎ3束のセット',
                'status_id' => '3',
            ],[
                'name' => '革靴',
                'image' => '',
                'price' => '4000',
                'description' => 'クラシックなデザインの革靴',
                'status_id' => '4',
            ],[
                'name' => 'ノートPC',
                'image' => '',
                'price' => '45000',
                'description' => '高性能なノートパソコン',
                'status_id' => '1',
            ],[
                'name' => 'マイク',
                'image' => '',
                'price' => '8000',
                'description' => '高品質のレコーディング用マイク',
                'status_id' => '2',
            ],[
                'name' => 'ショルダーバッグ',
                'image' => '',
                'price' => '3500',
                'description' => 'おしゃれなショルダーバッグ',
                'status_id' => '3',
            ],[
                'name' => 'タンブラー',
                'image' => '',
                'price' => '500',
                'description' => '使いやすいタンブラー',
                'status_id' => '4',
            ],[
                'name' => 'コーヒーミル',
                'image' => '',
                'price' => '4000',
                'description' => '手動のコーヒーミル',
                'status_id' => '1',
            ],[
                'name' => 'メイクセット',
                'image' => '',
                'price' => '2500',
                'description' => '便利なメイクアップセット',
                'status_id' => '2',
            ],
        ];

        Product::insert($users);
    }
}
