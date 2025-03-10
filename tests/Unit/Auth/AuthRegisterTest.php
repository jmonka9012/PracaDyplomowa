<?php

namespace Tests\Unit\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AuthRegisterTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_validates_and_creates_a_user_successfully()//sprawdza rejestracje
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123'
        ];

        $response = $this->post(route('register'), $data);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $user = User::where('email', 'john@example.com')->first();
        $this->assertTrue(Hash::check('Password123', $user->password));

        $response->assertRedirect(route('home'));
    }

    #[Test]
    public function it_fails_validation_with_invalid_data() // sprawdza działanie walidacji
    {
        $data = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123',
            'password_confirmation' => '123' //
        ];

        $response = $this->post(route('register'), $data);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }
}
