<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::domain('admin.mysite.com')->group(function()
{
    Route::get('/', function () {
        return 'This is my normal route';
    });
    Route::get('/dashboard', function () {
        return 'This is my admin dashboard';
    });
});

Route::get('/user/{id}/{name}', function ($id, $name) {
    return 'User Id:'.$id.' User Name:'.$name;
})->where(['id' => '[0-9]+', 'name' => '[a-zA-Z]+']);

Route::controller(StudentController::class)->middleware('auth')->group(function () {
    Route::get('/students', 'index');
    Route::get('/students/{id}', 'show');
});


Route::get('/dashboard',function(){
    return [
        'current'=>url()->current(),
        // 'full'=>url()->full(),
        'path'=>request()->path(),
        'current-url'=>request()->url(),
    ];
});


Route::get('/post',[PostController::class,'index']);


// Request data examples: reading values from the current request object.
Route::get('url-generation',function(){
    return [
        'current'=>url()->current(),
        'current-with-request'=>request()->current(),
        'fullURL-with-request'=>request()->fullUrl(),
        //'fullURL'=>url()->full(),
        'path'=>request()->path(),
        'previous'=>url()->previous(),
        'url'=>url('/home',['id'=>3]),
        'route'=>route('AB'),
        'action'
        ];
});

// Old input example: the form below repopulates fields after a validation error.
Route::get('/old-input', function () {
    return view('old-input');
})->name('old-input.form');

Route::post('/old-input', function () {
    request()->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email'],
        'message' => ['required', 'string', 'max:500'],
    ]);

    return redirect()->route('old-input.form')->with('status', 'Form submitted successfully.');
})->name('old-input.submit');

// File upload example: the uploaded file is stored on the public disk.
Route::get('/file-upload', function () {
    return view('file-upload');
})->name('file-upload.form');

Route::post('/file-upload', function () {
    $validated = request()->validate([
        'title' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string', 'max:500'],
        'attachment' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
    ]);

    $path = request()->file('attachment')->store('uploads', 'public');

    return redirect()
        ->route('file-upload.form')
        ->with('status', 'File uploaded successfully.')
        ->with('uploaded_file', [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'path' => $path,
            'url' => Storage::url($path),
            'original_name' => request()->file('attachment')->getClientOriginalName(),
        ]);
})->name('file-upload.submit');

// Cookie example: a cookie is written on submit and read back on the next request.
Route::get('/cookies', function () {
    return view('cookies', [
        'storedTheme' => request()->cookie('theme'),
    ]);
})->name('cookies.form');

Route::post('/cookies', function () {
    request()->validate([
        'theme' => ['required', 'in:light,dark,system'],
        'nickname' => ['nullable', 'string', 'max:50'],
    ]);

    return redirect()
        ->route('cookies.form')
        ->withCookie(cookie('theme', request('theme'), 60 * 24 * 30))
        ->withCookie(cookie('nickname', request('nickname', ''), 60 * 24 * 30))
        ->with('status', 'Cookie saved successfully.')
        ->with('cookie_preview', [
            'theme' => request('theme'),
            'nickname' => request('nickname'),
        ]);
})->name('cookies.submit');

    // Email example: send raw text, a Blade mailable, or a mailable with attachment.
    Route::get('/emails', function () {
        return view('emails.demo');
    })->name('emails.demo');

    Route::post('/emails', function () {
        $validated = request()->validate([
            'recipient' => ['required', 'email'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
            'mode' => ['required', 'in:raw,html,attachment'],
            'cc' => ['nullable', 'email'],
            'bcc' => ['nullable', 'email'],
            'reply_to' => ['nullable', 'email'],
            'attachment' => ['required_if:mode,attachment', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        if ($validated['mode'] === 'raw') {
            Mail::raw($validated['message'], function ($mail) use ($validated) {
                $mail->to($validated['recipient'])
                    ->subject($validated['subject']);

                if (! empty($validated['cc'])) {
                    $mail->cc($validated['cc']);
                }

                if (! empty($validated['bcc'])) {
                    $mail->bcc($validated['bcc']);
                }

                if (! empty($validated['reply_to'])) {
                    $mail->replyTo($validated['reply_to']);
                }
            });
        } else {
            $demoMail = new \App\Mail\DemoMail(
                subject: $validated['subject'],
                message: $validated['message'],
                senderName: config('app.name'),
                cc: $validated['cc'] ?? null,
                bcc: $validated['bcc'] ?? null,
                replyTo: $validated['reply_to'] ?? null,
                attachmentPath: $validated['mode'] === 'attachment' && request()->hasFile('attachment')
                    ? request()->file('attachment')->store('mail-attachments', 'public')
                    : null,
                attachmentName: $validated['mode'] === 'attachment' && request()->hasFile('attachment')
                    ? request()->file('attachment')->getClientOriginalName()
                    : null,
            );

            Mail::to($validated['recipient'])->send($demoMail);
        }

        return back()->with('status', 'Email example sent using the selected mode.');
    })->name('emails.send');

    