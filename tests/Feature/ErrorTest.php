<?php

namespace Tests\Feature;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ErrorTest extends TestCase
{
    #[Test]
    public function fallback_route_renders_404_page()
    {
        $response = $this->get('/non-existent-route');
        
        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('404')
        );
    }

    #[Test]
    public function fallback_route_includes_view_data()
    {
        $response = $this->get('/another-fake-route');
        
        $response->assertViewHas('title', 'strona nie znaleziona');
    }

    #[Test]
    public function error_controller_returns_proper_status_code()
    {
        $response = $this->get(route('error404'));
        $response->assertStatus(200);

        $fallbackResponse = $this->get('/invalid-route');
        $fallbackResponse->assertStatus(200);
    }
}