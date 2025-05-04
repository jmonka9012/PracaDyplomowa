<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\SupportTicket;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;


class CustomerServiceControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_the_status_of_a_ticket()
    {
        $user = User::factory()->create([
            'role' => 'admin'
        ]);
        $ticket = SupportTicket::factory()->create([
            'status' => 'in_progress',
        ]);

        $response = $this->actingAs($user)->put(route('admin.customer-service.change_status', $ticket->id), [
            'status' => 'closed',
            'id' => $ticket->id,
        ]);

        $this->assertDatabaseHas('support_tickets', [
            'id' => $ticket->id,
            'status' => 'closed',
        ]);
    }

    #[Test]
    public function it_validates_required_fields()
    {
        $user = User::factory()->create([
            'role' => 'admin'
        ]);
        $ticket = SupportTicket::factory()->create();

        $response = $this->actingAs($user)->put(route('admin.customer-service.change_status', $ticket->id), []);

        $response->assertSessionHasErrors(['status', 'id']);
    }

    #[Test]
    public function it_rejects_invalid_status()
    {
        $user = User::factory()->create([
            'role' => 'admin'
        ]);
        $ticket = SupportTicket::factory()->create();

        $response = $this->actingAs($user)->put(route('admin.customer-service.change_status', $ticket->id), [
            'status' => 'not_a_valid_status',
            'id' => $ticket->id,
        ]);

        $response->assertSessionHasErrors(['status']);
    }
}
