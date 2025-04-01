<?php

namespace Tests\Unit\Auth;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RequestEventTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_validates_and_creates_an_event_successfully()//sprawdza tworzenie eventu
    {
        $data = [
            'event_name'=>'Test456',
            'event_url'=>'Test456',
            'event_date'=>'1111-11-11',
            'event_start'=>'12:12:00',
            'event_end'=>'12:12:00',
            'contact_email'=>'Test456@test.com',
            'contact_email_additional'=>'Test456@test.com',
            'event_location'=>'1',
            'event_description'=>'Test456',
            'event_description_additional'=> 'Test456',
        ];

        $response = $this->post(route('event-create.post'), $data);
        $response->assertRedirect(route('home'));

        $this->assertDatabaseHas('events', [
            'event_name'=>'Test456',
            'event_url'=>'Test456',
            'event_date'=>'1111-11-11',
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
        $data = [
            'event_name'=>'',
            'event_url'=>str_repeat('a', 500),
            'event_date'=>'invalid',
            'event_start'=>'',
            'event_end'=>'',
            'contact_email'=>'invalid',
            'contact_email_additional'=>'invalid',
            'event_location'=>str_repeat('a', 500),
            'event_description'=>'',
            'event_description_additional'=>'',
        ];

        $response = $this->post(route('event-create.post'), $data);

        $response->assertSessionHasErrors(['event_name', 'event_url', 'event_date', 'event_start', 'event_end', 'contact_email', 'contact_email_additional', 'event_location', 'event_description', 'event_description_additional']);
    }
}
