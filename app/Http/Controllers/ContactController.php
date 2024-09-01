<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{

    public function index()
    {
        $contacts = Contact::all();
        return view('contacts.index',compact('contacts'));
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|string|max:255',
             'subject' => 'required|string|max:255',
             'description' => 'required|string|max:255',
        ]);
        Contact::create($validateData);
        return redirect()->back()->with('success','Contact created successfully');
    }


    public function show(Contact $contact)
    {
        return view('contacts.show',compact('contact'));
    }

    public function edit(Contact $contact)
    {
        return view('contacts.edit',compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:255',
       ]);
      
       $contact->update($validateData);
       return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');


    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return view('contacts.index')->with('success',"Contact deleted successfully");
;    }
}
