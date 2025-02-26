<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LogoutTest extends TestCase
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

        $this->user = User::create([
            'id' => '1',
            'name' => '一郎',
            'email' => 'ichiro@example',
            'password' => Hash::make('password'),
        ]);
    }
    
    public function test_logout_success()
    {
        $this->actingAs($this->user);
    
        $response = $this->postJson('/logout');

        $response->assertStatus(204);
        $this->assertGuest();
    }
}
