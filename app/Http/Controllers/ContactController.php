<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function send(ContactMessageRequest $request)
    {
        ContactMessage::create($request->validated());

        return redirect()->route('contact')
            ->with('success', "Your message has been sent! We'll be in touch soon.");
    }
}
