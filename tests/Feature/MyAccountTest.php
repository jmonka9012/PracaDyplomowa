<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\VerifyEmail;
use PHPUnit\Framework\Attributes\Test;
use Faker\Factory as Faker;

class MyAccountTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        $this->user = User::factory()->create();
    }

    #[Test]
    public function my_account_page_loads_successfully()
    {
        $this->actingAs($this->user)
            ->get('/moje-konto')
            ->assertInertia(
                fn ($page) => $page
                    ->component('My-Account')
            );
    }

    #[Test]
    public function user_can_update_profile_information()
    {
        $this->actingAs($this->user)
            ->withSession(['auth.password_confirmed_at' => now()->timestamp])
            ->post('/moje-konto', [
                'first_name' => 'New Name',
                'last_name' => 'New Name',
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123'
            ])
            ->assertRedirect()
            ->assertSessionHas('success', 'Profil zauktalizowany');

        $this->user->refresh();
        $this->assertEquals('New Name', $this->user->first_name);
        $this->assertEquals('New Name', $this->user->last_name);
        $this->assertTrue(Hash::check('newpassword123', $this->user->password));
    }

    #[Test]
    public function changing_email_sends_verification_and_resets_status()
    {   
        $newEmail = Faker::create()->unique()->safeEmail;

        
        $this->actingAs($this->user)
            ->withSession(['auth.password_confirmed_at' => now()->timestamp])
            ->post('/moje-konto', [
                'email' => $newEmail,
            ])
            ->assertRedirect()
            ->assertSessionHas('success', 'Profil zauktalizowany');
    
        $this->user->refresh();
        $this->assertEquals($newEmail, $this->user->email);
        $this->assertNull($this->user->email_verified_at);
        $this->assertEquals(UserRole::UNVERIFIED_USER, $this->user->role);
        $this->assertEquals(UserRole::UNVERIFIED_USER->permissionLevel(), $this->user->permission_level);

        Mail::assertSent(VerifyEmail::class, function ($mail) use ($newEmail) {
            return collect($mail->to)->pluck('address')->contains($newEmail);
        });
        
    
    }

    #[Test]
    public function updating_profile_requires_recent_password_confirmation()
    {
        $this->actingAs($this->user)
            ->withSession(['auth.password_confirmed_at' => now()->subMinutes(11)->timestamp])
            ->post('/moje-konto', [
                'name' => 'New Name',
            ])
            ->assertStatus(403)
            ->assertSee('Potwierdzenie hasła wygasło, proszę spróbuj ponownie.');
    }

}