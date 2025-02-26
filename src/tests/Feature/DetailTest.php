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
use App\Models\Bookmark;
use App\Models\Comment;
use App\Models\Profile;

class DetailTest extends TestCase
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

        ProductCategory::insert([
            [
                'id' => '1',
                'product_id' => '1',
                'category_id' => '1',
            ],[
                'id' => '2',
                'product_id' => '1',
                'category_id' => '2',
            ],[
                'id' => '3',
                'product_id' => '1',
                'category_id' => '3',
            ],
        ]);

        Bookmark::insert([
            [
                'id' => '1',
                'user_id' => '1',
                'product_id' => '1',
            ],[
                'id' => '2',
                'user_id' => '2',
                'product_id' => '1',
            ],
        ]);

        Comment::insert([
            'id' => '1',
            'user_id' => '1',
            'product_id' => '1',
            'comment' => 'コメント',
        ]);

        Profile::insert([
            'user_id' => '1',
            'image' => 'banana.png',
            'name' => '一郎',
            'zip_code' => '1111111',
            'address' => '住所1',
        ]);
    }
    
    public function test_detail_information()
    {
        $response = $this->get('/item/1');

        $response->assertStatus(200);

        $product = Product::find(1);

        $response->assertSee($product->image);

        $response->assertSee($product->name);

        $response->assertSee($product->brand);

        $response->assertSee(number_format($product->price));

        $response->assertSee(Bookmark::where('product_id', '1')->count());

        $response->assertSee(Comment::where('product_id', '1')->count());

        $response->assertSee($product->description);

        foreach ($product->categories as $category) {
            $response->assertSee($category->category);
        }

        $response->assertSee(Condision::find($product->condision_id)->condision);

        $comment = Comment::where('product_id', '1')->first();

        $commentUser = Profile::where('user_id', $comment->user_id)->first();

        $response->assertSee($commentUser->image);

        $response->assertSee($commentUser->name);

        $response->assertSee($comment->comment);
    }
}
