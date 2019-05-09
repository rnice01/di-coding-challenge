<?php


namespace App;


use App\Mail\ContactGuyMail;
use Illuminate\Support\Facades\Mail;

class ContactGuy
{

    /**
     * Sends an email to Guy and saves it to the database.
     *
     * @param $email
     * @param $name
     * @param $message
     * @param string $phone
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public static function notify(Contact $contact)
    {
        if ($contact == null)
            throw new \InvalidArgumentException("Contact can not be null");

        $mail = new ContactGuyMail($contact);

        Mail::send($mail);

        $contact->save();
    }
}
