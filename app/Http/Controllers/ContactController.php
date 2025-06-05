<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ContactFormMail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        // dd('we are here');
        return Inertia::render('Website/ContactUs');
    }
    public function send(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'subject' => 'required|string|max:150',
            'message' => 'required|string',
        ]);

        $admin_users = User::where('role','admin')->get();

        // dd($admin_users);

        // You can send an email or store to DB here
        // Mail::to('admin@example.com')->send(new ContactFormMail($validated));
        foreach($admin_users as $user)
        {
            $user->notify(new ContactFormMail($user,$validated));
        }

        return back()->with('success', 'Message sent successfully!');

    }
}
