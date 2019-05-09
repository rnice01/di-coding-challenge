<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeRouteTest extends TestCase
{
    /**
     * Test 200 response for root URL
     *
     * @return void
     */
    public function testRootUrlIsAccessible()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test contact form is rendered
     */
    public function testContactFormIsShown()
    {
        $response = $this->get('/');

        $response->assertSeeText('Contact Guy Smiley');
    }
}
