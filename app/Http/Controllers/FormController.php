<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;

class FormController extends Controller
{
    public function showForm()
    {
        return view('formvalidation');
    }

    public function submitForm(StoreUserRequest $request)
    {
        $validated = $request->validated();

        return "Form submitted successfully! Student Name: {$validated['studentname']}, Email: {$validated['email']}";
    }
}
