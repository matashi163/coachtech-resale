<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Condision;
use App\Models\Product;
use App\Models\PurchasedProduct;

class ListTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        User::insert([
            [
                'id' => '1',
                'name' => '一郎',
                'email' => 'ichiro@example',
                'password' => Hash::make('password'),
                'first_login' => false,
            ],[
                'id' => '2',
                'name' => '二郎',
                'email' => 'jiro@example',
                'password' => Hash::make('password'),
                'first_login' => false,
            ],[
                'id' => '3',
                'name' => '三郎',
                'email' => 'saburo@example',
                'password' => Hash::make('password'),
                'first_login' => false,
            ],[
                'id' => '4',
                'name' => '四郎',
                'email' => 'shiro@example',
                'password' => Hash::make('password'),
                'first_login' => false,
            ],[
                'id' => '5',
                'name' => '五郎',
                'email' => 'goro@example',
                'password' => Hash::make('password'),
                'first_login' => false,
            ],
        ]);

        Condision::insert([
            [
                'id' => '1',
                'condision' => '良好',
            ],[
                'id' => '2',
                'condision' => '目立った傷や汚れなし',
            ],[
                'id' => '3',
                'condision' => 'やや傷や汚れあり',
            ],[
                'id' => '4',
                'condision' => '状態が悪い',
            ],
        ]);

        Product::insert([
            [
                'id' => '1',
                'name' => '腕時計',
                'image' => 'watch.jpg',
                'price' => '15000',
                'description' => 'スタイリッシュなデザインのメンズ時計',
                'condision_id' => '1',
                'selling_user_id' => '1',
            ],[
                'id' => '2',
                'name' => 'HDD',
                'image' => 'HDD.jpg',
                'price' => '5000',
                'description' => '高速で信頼性の高いハードディスク',
                'condision_id' => '2',
                'selling_user_id' => '1',
            ],[
                'id' => '3',
                'name' => '玉ねぎ3束',
                'image' => 'onion.jpg',
                'price' => '300',
                'description' => '新鮮な玉ねぎ3束のセット',
                'condision_id' => '3',
                'selling_user_id' => '2',
            ],[
                'id' => '4',
                'name' => '革靴',
                'image' => 'leather_shoes.jpg',
                'price' => '4000',
                'description' => 'クラシックなデザインの革靴',
                'condision_id' => '4',
                'selling_user_id' => '2',
            ],[
                'id' => '5',
                'name' => 'ノートPC',
                'image' => 'laptop.jpg',
                'price' => '45000',
                'description' => '高性能なノートパソコン',
                'condision_id' => '1',
                'selling_user_id' => '3',
            ],[
                'id' => '6',
                'name' => 'マイク',
                'image' => 'mic.jpg',
                'price' => '8000',
                'description' => '高品質のレコーディング用マイク',
                'condision_id' => '2',
                'selling_user_id' => '3',
            ],[
                'id' => '7',
                'name' => 'ショルダーバッグ',
                'image' => 'shoulder_bag.jpg',
                'price' => '3500',
                'description' => 'おしゃれなショルダーバッグ',
                'condision_id' => '3',
                'selling_user_id' => '4',
            ],[
                'id' => '8',
                'name' => 'タンブラー',
                'image' => 'tumbler.jpg',
                'price' => '500',
                'description' => '使いやすいタンブラー',
                'condision_id' => '4',
                'selling_user_id' => '4',
            ],[
                'id' => '9',
                'name' => 'コーヒーミル',
                'image' => 'coffee_grinder.jpg',
                'price' => '4000',
                'description' => '手動のコーヒーミル',
                'condision_id' => '1',
                'selling_user_id' => '5',
            ],[
                'id' => '10',
                'name' => 'メイクセット',
                'image' => 'makeup_set.jpg',
                'price' => '2500',
                'description' => '便利なメイクアップセット',
                'condision_id' => '2',
                'selling_user_id' => '5',
            ],
        ]);
    }
    
    public function test_list()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $products = Product::all();

        foreach ($products as $product) {
            $response->assertSee($product->name);
        }
    }

    public function test_list_display_sold()
    {
        PurchasedProduct::insert([
            'id' => '1',
            'product_id' => '1',
            'buying_user_id' => '1',
            'zip_code' => '1234567',
            'address' => 'address',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('Sold');
    }

    public function test_list_hidden_my_product()
    {
        $this->actingAs(User::find(1));
        
        $response = $this->get('/');

        $products = Product::where('selling_user_id', auth()->id())->get();

        foreach ($products as $product) {
            $response->assertDontSee($product->name);
        }
    }
}
