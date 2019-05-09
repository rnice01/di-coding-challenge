<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactFormControllerTest extends TestCase
{
    /**
     * Test validation for required email field POSTed
     *
     * @dataProvider badEmails
     *
     * @return void
     */
    public function testValidationErrorWhenEmailInvalid($badEmail)
    {
        $response = $this->post('/contact-guy', ['email' => $badEmail]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test validation for required full_name field POSTed
     *
     * @return void
     */
    public function testValidationErrorWhenFullNameEmpty()
    {
        $response = $this->post('/contact-guy', ['full_name' => '']);

        $response->assertSessionHasErrors(['full_name']);
    }

    /**
     * Test validation for required message field POSTed
     */
    public function testValidationErrorWhenMessageEmpty()
    {
        $response = $this->post('/contact-guy', ['message' => '']);

        $response->assertSessionHasErrors(['message']);
    }

    /**
     * Test validation for optional phone field POSTed
     */
    public function testNoValidationErrorWhenPhoneEmpty()
    {
        $response = $this->post('/contact-guy', ['phone' => '']);

        $response->assertSessionDoesntHaveErrors(['phone']);
    }

    /**
     * Test success message sent if no errors
     */
    public function testSuccessMessageAndRedirectIfNoErrors()
    {
        $response = $this->followingRedirects()
            ->post('/contact-guy', ['message' => 'message', 'email' => 'good@email.com', 'full_name' => 'full name']);

        $response->assertSeeText('Guy has received your message');
    }


    /**
     * Invalid emails data provider
     *
     * @return array
     */
    public function badEmails()
    {
        return [
            [null],
            [''],
            ['nope.com'],
            ['@.com'],
            ['test@'],
            ['@test.com']
        ];
    }
}
