<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\OrganizerInformation;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class RequestEventTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_validates_and_creates_an_event_successfully()
    {   
        Storage::fake('public');
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'role' => 'organizer'
        ]);

        $organizer = OrganizerInformation::factory()->create([
            'user_id' => $user->id
        ]);
    
        $this->actingAs($user);

        $data = [
            'event_name'=>'Test456',
            'organizer_id' => $user->organizer->id,
            'event_date'=>'2222-11-11',
            'event_start'=>'12:12:00',
            'event_end'=>'12:12:00',
            'contact_email'=>'Test456@test.com',
            'contact_email_additional'=>'Test456@test.com',
            'event_location'=>'1',
            'event_description'=>'Test456',
            'event_image'=> UploadedFile::fake()->image('event.jpg', 800, 600),
            'event_description_additional'=> 'Test456',
            'genre' =>[
                ['value' => 1]
            ],
            'section_prices' => [
                '1' => '1',
                '2' => '2', 
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            ],

        ];

        $response = $this->post(route('event-create.post'), $data);
        $response->assertRedirect(route('home'));

        $this->assertDatabaseHas('events', [
            'event_name'=>'Test456',
            'organizer_id' => $user->organizer->id,
            'event_date'=>'2222-11-11',
            'event_start'=>'12:12:00',
            'event_end'=>'12:12:00',
            'contact_email'=>'Test456@test.com',
            'contact_email_additional'=>'Test456@test.com',
            'event_location'=>'1',
            'event_description'=>'Test456',
            'event_description_additional'=> 'Test456',
        ]);
    }

    #[Test]
    public function it_fails_validation_with_invalid_data() // sprawdza działanie walidacji
    {
        $user = User::factory()->create([
            'role' => 'admin'
        ]);
        $this->actingAs($user);

        $data = [
            'event_name'=>'',
            //'event_additional_url'=>str_repeat('a', 500),
            'event_date'=>'invalid',
            'event_start'=>'',
            'event_end'=>'',
            'contact_email'=>'invalid',
            'contact_email_additional'=>'invalid',
            'event_location'=>str_repeat('a', 500),
            'event_description'=>'',
            'event_description_additional'=>str_repeat('a', 655356),
        ];

        $response = $this->post(route('event-create.post'), $data);

        $response->assertSessionHasErrors(['event_name', 'event_date', 'event_start', 'event_end', 'contact_email', 'contact_email_additional', 'event_location', 'event_description', 'event_description_additional']);
    }
}
