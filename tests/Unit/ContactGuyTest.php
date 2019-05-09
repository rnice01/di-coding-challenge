<?php

namespace Tests\Unit;

use App\Contact;
use App\ContactGuy;
use App\Mail\ContactGuyMail;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactGuyTest extends TestCase
{

    /**
     * Test mail has name, phone, and message
     * from the Contact model
     */
    public function testMailContainsSendersName()
    {
        $contact = new Contact;
        $contact['full_name'] = 'Richter B.';
        $contact['message'] = 'Message to Guy Smiley';
        $contact['phone'] = '2132123';
        $contact['email'] = 'vk@belmonts.com';

        Mail::fake();

        ContactGuy::notify($contact);

        Mail::assertSent(ContactGuyMail::class, function ($mail) use ($contact) {
            $m = $mail->build();
            $body = view($m->view, $m->viewData)->render();

            return strpos($body, $contact['full_name']) !== false &&
                strpos($body, $contact['message']) !== false &&
                strpos($body, $contact['phone']) !== false;
        });
    }

    /**
     * Test Contact created in database
     */
    public function testContactCreated()
    {
        $contact = new Contact;
        $contact['full_name'] = 'sender';
        $contact['message'] = 'message';
        $contact['phone'] = '2132123';
        $contact['email'] = 'good@email.com';

        Mail::fake();

        ContactGuy::notify($contact);

        $this->assertDatabaseHas('contacts', [
            'email' => $contact['email'],
            'full_name' => $contact['full_name'],
            'phone' => $contact['phone'],
            'message' => $contact['message']
        ]);
    }

}
