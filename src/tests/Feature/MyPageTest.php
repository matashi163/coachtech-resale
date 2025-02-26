<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;
use App\Models\Condision;
use App\Models\Product;
use App\Models\PurchasedProduct;

class MyPageTest extends TestCase
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
                'brand' => 'ブランド',
                'price' => '15000',
                'description' => 'スタイリッシュなデザインのメンズ時計',
                'condision_id' => '1',
                'selling_user_id' => '1',
            ],[
                'id' => '2',
                'name' => 'HDD',
                'image' => 'HDD.jpg',
                'brand' => 'ブランド',
                'price' => '5000',
                'description' => '高速で信頼性の高いハードディスク',
                'condision_id' => '2',
                'selling_user_id' => '2',
            ],
        ]);

        PurchasedProduct::insert([
            'id' => '1',
            'buying_user_id' => '1',
            'product_id' => '2',
            'zip_code' => '1111111',
            'address' => '住所1'
        ]);

        Profile::insert([
            'id' => '1',
            'user_id' => '1',
            'image' => 'banana.png',
            'name' => '一郎',
            'zip_code' => '1111111',
            'address' => '住所1',
        ]);

        $this->actingAs(User::find(1));
    }
     
    public function test_mypage()
    {
        $response = $this->get('/mypage');

        $profile = Profile::where('user_id', '1')->first();
        
        $response->assertSee($profile->image);

        $response->assertSee($profile->name);
        
        $response = $this->get('/mypage?page=sell');

        $response->assertStatus(200);

        $response->assertSee(Product::where('selling_user_id', '1')->first()->name);

        $response = $this->get('/mypage?page=buy');

        $response->assertStatus(200);

        $response->assertSee(PurchasedProduct::where('buying_user_id', '1')->first()->name);
    }
}
