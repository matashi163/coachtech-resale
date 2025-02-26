<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Condision;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class SellTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        User::insert([
            'id' => '1',
            'name' => '一郎',
            'email' => 'ichiro@example',
            'password' => Hash::make('password'),
            'first_login' => false,
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

        Category::insert([
            [
                'id' => '1',
                'category' => 'ファッション',
            ],[
                'id' => '2',
                'category' => 'メンズ',
            ],[
                'id' => '3',
                'category' => 'アクセサリー',
            ],
        ]);

        $this->actingAs(User::find(1));
    }

    public function test_sell()
    {
        Storage::fake('public');
        
        $image = new UploadedFile(storage_path('app/public/user_icons/kiwi.png'), 'kiwi.png', 'image/png', null, true);
        
        $response = $this->postJson('/sell', [
            'image' => $image,
            'category' => [
                '1',
                '2',
                '3',
            ],
            'condision' => '1',
            'name' => '腕時計',
            'brand' => 'ブランド',
            'description' => 'スタイリッシュなデザインのメンズ時計',
            'price' => '15000',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('products', [
            'image' => 'kiwi.png',
            'condision_id' => '1',
            'name' => '腕時計',
            'brand' => 'ブランド',
            'description' => 'スタイリッシュなデザインのメンズ時計',
            'price' => '15000',
            'selling_user_id' => '1',
        ]);

        $this->assertDatabaseHas('product_categories', [
            'category_id' => '1',
        ]);

        $this->assertDatabaseHas('product_categories', [
            'category_id' => '2',
        ]);

        $this->assertDatabaseHas('product_categories', [
            'category_id' => '3',
        ]);
    }
}
