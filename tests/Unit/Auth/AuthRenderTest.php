<?php
namespace Tests\Unit\Auth;

use Tests\TestCase;
use Inertia\Testing\AssertableInertia;

class AuthRenderTest extends TestCase
{
    /** @test */
    public function it_renders_the_registration_form_with_correct_data()//sprawdze czy strona się renderuje, bez css, tylko czy wszystkie częsci są
    {
        $response = $this->get(route('register'));
        $response->assertInertia(fn (AssertableInertia $inertia) => 
            $inertia->component('Forms')
                ->has('message')
                ->has('csrf_token')
        );
    }
}
