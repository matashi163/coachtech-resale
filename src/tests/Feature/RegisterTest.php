<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function test_register_name_validation()
    {
        $response = $this->postJson('/register', [
            'name' => '',
            'email' => 'ichiro@example',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['name']);

        $response->assertJson([
            'errors' => [
                'name' => ['お名前を入力してください'],
            ],
        ]);
    }

    public function test_register_email_validation()
    {
        $response = $this->postJson('/register', [
            'name' => 'ichiro',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['email']);

        $response->assertJson([
            'errors' => [
                'email' => ['メールアドレスを入力してください'],
            ],
        ]);
    }

    public function test_register_password_reqiured_validation()
    {
        $response = $this->postJson('/register', [
            'name' => 'ichiro',
            'email' => 'ichiro@example',
            'password' => '',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['password']);

        $response->assertJson([
            'errors' => [
                'password' => ['パスワードを入力してください'],
            ],
        ]);
    }

    public function test_register_password_min_validation()
    {
        $response = $this->postJson('/register', [
            'name' => 'ichiro',
            'email' => 'ichiro@example',
            'password' => 'passwor',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['password']);

        $response->assertJson([
            'errors' => [
                'password' => ['パスワードは8文字以上で入力してください'],
            ],
        ]);
    }

    public function test_register_password_confirmation_validation()
    {
        $response = $this->postJson('/register', [
            'name' => 'ichiro',
            'email' => 'ichiro@example',
            'password' => 'password',
            'password_confirmation' => 'different_password',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['password_confirmation']);

        $response->assertJson([
            'errors' => [
                'password_confirmation' => ['パスワードと一致しません'],
            ],
        ]);
    }

    public function test_register_success()
    {
        $response = $this->postJson('/register', [
            'name' => 'ichiro',
            'email' => 'ichiro@example',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'ichiro',
            'email' => 'ichiro@example',
        ]);

        $this->assertTrue(Hash::check('password', User::where('email', 'ichiro@example')->first()->password));

        $response->assertRedirect('/login');
    }
}
