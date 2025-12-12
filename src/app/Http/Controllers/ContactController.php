<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->except('_token');
        return view('confirm', compact('contact'));
    }

    public function store(ContactRequest $request)
    {
        $data = [];

        $data['first_name']  = $request->first_name;
        $data['last_name']   = $request->last_name;
        $data['gender']      = (int) $request->gender;
        $data['email']       = $request->email;
        $data['tel']         = $request->tel1 . $request->tel2 . $request->tel3;
        $data['address']     = $request->address;
        $data['building']    = $request->building ?: null;
        $data['category_id'] = (int) $request->category_id;
        $data['detail']     = $request->detail;

        Contact::create($data);

        return view('thanks');
    }

    public function back(ContactRequest $request)
    {
        return redirect()
            ->route('contacts.index')
            ->withInput($request->except('_token'));
    }
}
