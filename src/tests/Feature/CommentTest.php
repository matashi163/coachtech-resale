<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Condision;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Profile;

class CommentTest extends TestCase
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
    }

    public function test_comment()
    {
        $this->actingAs(User::find(2));
        
        $response = $this->postJson('/comment', [
            'comment' => 'コメント',
            'product_id' => '1',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('comments', [
            'user_id' => '2',
            'product_id' => '1',
            'comment' => 'コメント',
        ]);

        $response = $this->get('/item/1');

        $response->assertStatus(200);

        $response->assertSee(Comment::where('product_id', '1')->count());
    }

    public function test_comment_guest()
    {
        $response = $this->postJson('/comment', [
            'comment' => 'コメント',
            'product_id' => '1',
        ]);

        $response->assertStatus(401);
    }

    public function test_comment_validation_required()
    {
        $this->actingAs(User::find(2));
        
        $response = $this->postJson('/comment', [
            'comment' => '',
            'product_id' => '1',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['comment']);
    }

    public function test_comment_validation_max()
    {
        $this->actingAs(User::find(2));
        
        $response = $this->postJson('/comment', [
            'comment' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'product_id' => '1',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['comment']);
    }
}
