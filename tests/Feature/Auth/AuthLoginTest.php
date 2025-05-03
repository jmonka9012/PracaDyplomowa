<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AuthLoginTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_renders_the_login_page()
    {
        $response = $this->get(route('login'));
        
        $response->assertStatus(200)
                 ->assertSee('Logowanie');
    }

    #[Test]
    public function it_logs_in_a_user_with_valid_credentials()
    {
        $user = User::factory()->create([
            'name' => 'testuser',
            'email' => 'john2@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('my-account'));
    }

    #[Test]
    public function it_fails_to_login_with_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'john3@example.com',
            'password' => bcrypt('12341234'),
        ]);

        $response = $this->post(route('login'), [
            'login' => 'john3@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('password');
    }
}
