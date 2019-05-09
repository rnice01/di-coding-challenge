<?php

namespace App\Mail;

use App\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactGuyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Contact model
     *
     * @var Contact
     */
    public $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from($this->contact['email']);
        $this->to('guy-smiley@example.com');
        return $this->view('emails.contact-guy')->with([
            'name' => $this->contact['full_name'],
            'messageFromContact' => $this->contact['message'],
            'phone' => $this->contact['phone']
        ]);
    }
}
