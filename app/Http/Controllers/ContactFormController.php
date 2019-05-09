<?php


namespace App\Http\Controllers;

use App\Contact;
use App\ContactGuy;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ContactFormController extends BaseController
{

    /**
     * Handles POST from Guy's Contact Form. Checks for valid email
     * and ensures, name, and message are also provided.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Use the Validator facade to make sure
        // the required fields have been sent as
        // well as making sure the email is valid
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'full_name' => 'required',
            'message' => 'required'
        ]);

        // Redirect the user to the page with the form
        // with the form errors so we can display them
        // in the blade template
        if ($validator->fails()) {
            return redirect('/#contact')
                ->withErrors($validator)
                ->withInput();
        }

        // Call our service to send the email to
        // guy and persist the data to the DB.
        $newContact = $this->buildContact($request->all());
        ContactGuy::notify($newContact);

        return redirect('/#contact')->with([
            'message' => 'success'
        ]);
    }

    private function buildContact($postParams)
    {
        $phone = empty($postParams['phone']) ? '' : $postParams['phone'];

        $contact = new Contact;
        $contact['full_name'] = $postParams['full_name'];
        $contact['email'] = $postParams['email'];
        $contact['message'] = $postParams['message'];
        $contact['phone'] = $phone;

        return $contact;
    }
}
