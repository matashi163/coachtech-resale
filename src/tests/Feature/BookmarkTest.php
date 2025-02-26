<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Condision;
use App\Models\Product;
use App\Models\Bookmark;

class BookmarkTest extends TestCase
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

        $this->actingAs(User::find(2));
    }
     
    public function test_bookmark()
    {
        $response = $this->get('/bookmark/create/1');

        $response->assertStatus(302);

        $this->assertDatabaseHas('bookmarks', [
            'user_id' => '2',
            'product_id' => '1',
        ]);

        $response = $this->get('/item/1');

        $response->assertStatus(200);

        $response->assertSee(Bookmark::where('product_id', '1')->count());
    }

    public function test_bookmark_change_color()
    {
        Bookmark::insert([
            'id' => '1',
            'user_id' => '2',
            'product_id' => '1',
        ]);

        $response = $this->get('/item/1');

        $response->assertStatus(200);

        $response->assertSee('bookmarked');
    }

    public function test_bookmark_delete()
    {
        Bookmark::insert([
            'id' => '1',
            'user_id' => '2',
            'product_id' => '1',
        ]);

        $response = $this->get('/bookmark/delete/1');

        $response->assertStatus(302);

        $this->assertDatabaseMissing('bookmarks', [
            'user_id' => '2',
            'product_id' => '1',
        ]);

        $response = $this->get('/item/1');

        $response->assertStatus(200);

        $response->assertSee(Bookmark::where('product_id', '1')->count());
    }
}
