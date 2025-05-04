<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;

class CustomerSupportRequestTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function guest_can_create_support_ticket_with_required_fields()
    {   
        $response = $this->post(route('support-ticket-send'), [
            'topic' => 'Login issues',
            'message' => 'I cannot login to my account',
            'email' => 'guest@example.com',
            'name' => 'Guest User',
        ]);

        $this->assertDatabaseHas('support_tickets', [
            'topic' => 'Login issues',
            'email' => 'guest@example.com',
            'name' => 'Guest User',
            'user_id' => null,
        ]);
    }

    #[Test]
    public function authenticated_user_has_user_data_automatically_appended()
    {
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
        ]);

        $response = $this->actingAs($user)
            ->post(route('support-ticket-send'), [
                'topic' => 'Payment problem',
                'message' => 'My payment was declined',
            ]);

        $this->assertDatabaseHas('support_tickets', [
            'topic' => 'Payment problem',
            'email' => 'john@example.com',
            'name' => 'John Doe',
            'user_id' => $user->id,
        ]);
    }

    #[Test]
    public function authenticated_user_cannot_override_automatic_fields()
    {
        $user = User::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane@example.com',
        ]);

        $response = $this->actingAs($user)
            ->post(route('support-ticket-send'), [
                'topic' => 'Feature request',
                'message' => 'Please add dark mode',
                'email' => 'malicious@example.com',
                'name' => 'Hacker',
                'user_id' => 9999,
            ]);

        $this->assertDatabaseHas('support_tickets', [
            'email' => 'jane@example.com',
            'name' => 'Jane Smith',
            'user_id' => $user->id,
        ]);
    }

    #[Test]
    public function validation_works_for_required_fields()
    {
        $response = $this->post(route('support-ticket-send'), []);
        $response->assertSessionHasErrors(['topic', 'message', 'email', 'name']);
    
        $user = User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
        ]);
        
        $response = $this->actingAs($user)
            ->post(route('support-ticket-send'), []);
        $response->assertSessionHasErrors(['topic', 'message']);
        $response->assertSessionDoesntHaveErrors(['email', 'name']);
    }
    
}