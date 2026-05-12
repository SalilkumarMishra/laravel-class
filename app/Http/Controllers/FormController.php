<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public function showForm()
    {
        return view('form');
    }

    public function submitForm(Request $request)
    {
        $username = $request->input('username');
        $email = $request->input('email');

        // Process the form data as needed
        // For example, you can save it to the database or perform validation
        $request->validate(
            [
                'username' => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ],
            [
                'email.required' => 'The email field is required.',
            ]
        );
        return "Form submitted successfully! Username: $username, Email: $email";
    }
}
