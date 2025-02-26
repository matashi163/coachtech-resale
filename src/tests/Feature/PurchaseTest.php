<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Condision;
use App\Models\Product;
use App\Models\Profile;
use App\Models\PurchasedProduct;

class PurchaseTest extends TestCase
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
            'id' => '1',
            'name' => '腕時計',
            'image' => 'watch.jpg',
            'brand' => 'ブランド',
            'price' => '15000',
            'description' => 'スタイリッシュなデザインのメンズ時計',
            'condision_id' => '1',
            'selling_user_id' => '1',
        ]);

        Profile::insert([
            'id' => '1',
            'user_id' => '2',
            'image' => 'banana.png',
            'name' => '二郎',
            'zip_code' => '2222222',
            'address' => '住所2',
        ]);

        $this->actingAs(User::find(2));
    }
     
    public function test_purchase()
    {
        $response = $this->get('/purchase?product_id=1&user_id=2&zip_code=2222222&address=住所&building=建物');

        $response->assertStatus(302);

        $this->assertDatabaseHas('purchased_products', [
            'product_id' => '1',
            'buying_user_id' => '2',
            'zip_code' => '2222222',
            'address' => '住所',
            'building' => '建物'
        ]);
    }

    public function test_purchase_display_sold()
    {
        $response = $this->get('/purchase?product_id=1&user_id=2&zip_code=2222222&address=住所&building=建物');

        $response->assertStatus(302);
        
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('Sold');
    }

    public function test_purchase_profile()
    {
        $response = $this->get('/purchase?product_id=1&user_id=2&zip_code=2222222&address=住所&building=建物');

        $response->assertStatus(302);

        $response = $this->get('/mypage?page=buy');

        $response->assertStatus(200);

        foreach (PurchasedProduct::where('buying_user_id', '2')->get() as $product) {
            $response->assertSee($product->name);
        }
    }
}
