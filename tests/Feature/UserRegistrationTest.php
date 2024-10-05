<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterNewUserSuccessfully(): void
    {
        $response = $this->post('/register', [
            'login' => 'testuser',
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
        ]);

        $response->assertRedirect('/home');
        $this->assertDatabaseHas('users', [
            'login' => 'testuser',
        ]);
    }

    public function testFailIfPasswordTooShort(): void
    {
        $response = $this->post('/register', [
            'login' => 'testuser',
            'password' => '12345',
            'password_confirmation' => '12345',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function testFailIfLoginIsTaken(): void
    {
        User::create([
            'login' => 'testuser',
            'password' => 'testpassword',
        ]);

        $response = $this->post('/register', [
            'login' => 'testuser',
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
        ]);

        $response->assertSessionHasErrors('login');
    }

    public function testFailIfPasswordsDontMach(): void
    {
        $response = $this->post('/register', [
            'login' => 'testuser',
            'password' => 'testpassword1',
            'password_confirmation' => 'testpassword2',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
