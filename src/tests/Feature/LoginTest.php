<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        User::create([
            'id' => '1',
            'name' => '一郎',
            'email' => 'ichiro@example',
            'password' => Hash::make('password'),
        ]);
    }

    public function test_login_email_validation()
    {
        $response = $this->postJson('/login', [
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['email']);

        $response->assertJson([
            'errors' => [
                'email' => ['メールアドレスを入力してください'],
            ],
        ]);
    }

    public function test_login_password_validation()
    {
        $response = $this->postJson('/login', [
            'email' => 'ichiro@example',
            'password' => '',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['password']);

        $response->assertJson([
            'errors' => [
                'password' => ['パスワードを入力してください'],
            ],
        ]);
    }

    public function test_login_different_validation()
    {
        $response = $this->postJson('/login', [
            'email' => 'jiro@example',
            'password' => 'password',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['email']);

        $response->assertJson([
            'errors' => [
                'email' => ['ログイン情報が登録されていません'],
            ],
        ]);
    }

    public function test_login_success()
    {
        $response = $this->postJson('/login', [
            'email' => 'ichiro@example',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticated();
    }
}
