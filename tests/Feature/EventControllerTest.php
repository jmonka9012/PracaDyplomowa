<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Events\Event;
use App\Models\Events\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;

class EventControllerTest extends TestCase
{
    use DatabaseTransactions;
    
    #[Test]
    public function show_displays_event_with_related_events()
    {
        $eventUrl = Event::where('event_name', 'David Bowie 2020s')->value('event_url');
        $response = $this->get(route('event.show', $eventUrl));
        
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Events/EventSingle')
            ->has('event')
            ->has('related_events')
        );
    }

    #[Test]
    public function component_404_renders_with_non_existent_event()
    {
        // Ensure no matching event exists
        Event::where('event_url', 'non-existent-event')->delete();
    
        $response = $this->get(route('event.show', 'non-existent-event'));
        
        $response->assertInertia(function ($page) {
            return $page->component('404'); 
        });
    }

    #[Test]
    public function event_browser_redirects_with_page_parameter_if_missing()
    {
        $response = $this->get(route('event.browser', ['event_name' => 'test']));
        
        $response->assertRedirect(route('event.browser', ['page' => 1, 'event_name' => 'test']));
    }

    #[Test]
    public function event_browser_filters_by_event_name()
    {
        
        $response = $this->get(route('event.browser', [
            'page' => 1,
            'event_name' => 'David Bowie 2020s'
        ]));
        
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Events/EventBrowser')
            ->where('events.data.0.event_name', 'David Bowie 2020s')
            ->missing('events.data.1')
        );
    }

    #[Test]
    public function event_browser_has_all_genres()
    {
        $genreAmount = Genre::count();
        $response = $this->get(route('event.browser', ['page' => 1]));
        
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->has('genres', $genreAmount)
        );
    }

    #[Test]
    public function event_browser_filters_by_genres()
    {
        $rockGenre = Genre::where('genre_name', 'Rock')->first();
        $metalGenre = Genre::where('genre_name', 'Metal')->first();
        $nuMetalGenre = Genre::where('genre_name', 'Nu Metal')->first();
    
        $response = $this->get(route('event.browser', [
            'page' => 1,
            'genres' => $metalGenre->id
        ]));
        
        $response->assertStatus(200);
        
        $metalEvents = Event::whereHas('genres', function($q) use ($metalGenre) {
            $q->where('genres.id', $metalGenre->id);
        })->where('pending', false)->get();

        $response->assertInertia(fn ($page) => $page
            ->has('events.data', $metalEvents->count())
        );

        $response = $this->get(route('event.browser', [
            'page' => 1,
            'genres' => $nuMetalGenre->id
        ]));
        
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->has('events.data', 1)
            ->where('events.data.0.event_name', 'System Of A Down Reunion')
        );
        
        $response = $this->get(route('event.browser', [
            'page' => 1,
            'genres' => $rockGenre->id
        ]));
        
        $rockEvents = Event::whereHas('genres', function($q) use ($rockGenre) {
            $q->where('genres.id', $rockGenre->id);
        })->where('pending', false)->get();
        
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->has('events.data', $rockEvents->count())
        );
    }
}