<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;

class ProfileTest extends TestCase
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

    public function test_profile()
    {
        $response = $this->get('/mypage/profile');

        $response->assertStatus(200);

        $profile = Profile::where('user_id', '1')->first();
        
        $response->assertSee($profile->image);

        $response->assertSee($profile->name);

        $response->assertSee($profile->zip_code);

        $response->assertSee($profile->address);

        $response->assertSee($profile->building);
    }
}
