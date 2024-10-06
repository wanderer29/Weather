<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
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

        //User in database
        $this->assertDatabaseHas('users', [
            'login' => 'testuser',
        ]);

        //Auth user
        $user = User::where('login', 'testuser')->first();
        $this->actingAs($user);
        $this->assertTrue(Auth::check());

        $response->assertRedirect(route('home'));
    }

    public function testFailedRegisterIfLoginAlreadyTaken(): void
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

        $response->assertSessionHasErrors(['login']);
        $this->assertEquals(1, User::where('login', 'testuser')->count());
    }

    public function testSessionExpiresAfterRegistrationAndLogout(): void
    {
        $this->post(route('user.register'), [
            'login' => 'testuser',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $sessionId = session()->getId();
        $this->post(route('logout'));

        $this->assertFalse(Auth::check());
        $this->assertNotEquals($sessionId, session()->getId());
    }

    public function testRegistrationFailsWhenLoginOrPasswordIsEmpty(): void
    {
        $response = $this->post('/register', [
            'login' => '',
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
        ]);

        $response->assertSessionHasErrors(['login']);

        $response = $this->post('/register', [
            'login' => 'testuser',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function testRegistrationFailsWhenPasswordConfirmationDoesNotMatch(): void
    {
        $response = $this->post('/register', [
            'login' => 'testuser',
            'password' => 'testpassword1',
            'password_confirmation' => 'testpassword2',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

}
