<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\FormController;


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

require __DIR__ . '/auth.php';


Route::domain('admin.mysite.com')->group(function () {
    Route::get('/', function () {
        return 'This is my normal route';
    });
    Route::get('/dashboard', function () {
        return 'This is my admin dashboard';
    });
});

Route::get('/user/{id}/{name}', function ($id, $name) {
    return 'User Id:' . $id . ' User Name:' . $name;
})->where(['id' => '[0-9]+', 'name' => '[a-zA-Z]+']);

Route::controller(StudentController::class)->middleware('auth')->group(function () {
    Route::get('/students', 'index');
    Route::get('/students/{id}', 'show');
});


Route::get('/dashboard', function () {
    return [
        'current' => url()->current(),
        // 'full'=>url()->full(),
        'path' => request()->path(),
        'current-url' => request()->url(),
    ];
});


Route::get('/post', [PostController::class, 'index']);


// Request data examples: reading values from the current request object.
Route::get('url-generation', function () {
    return [
        'current' => url()->current(),
        'current-with-request' => request()->current(),
        'fullURL-with-request' => request()->fullUrl(),
        //'fullURL'=>url()->full(),
        'path' => request()->path(),
        'previous' => url()->previous(),
        'url' => url('/home', ['id' => 3]),
        'route' => route('AB'),
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


// Route::get('/session-data', function (Request $request) {

//     // Store data
//     $request->session()->put('Name', 'Salil');
//     $request->session()->put([
//         'Age' => 24,
//         'City' => 'Indore',
//         'fruits' => []
//     ]);

//     // Push into array
//    // $request->session()->push('fruits', 'Apple');
//     return [
//         'Name' => session('Name'),
//         'Age' => session('Age'),
//         'City' => session('City', 'Default City'),
//         'fruits' => session('fruits'),
//     ];
// });

Route::get('/set', function (Request $request) {
    //$request->session()->now('info', 'Hello Flash'); //now value will be available in current request but not in next request
    return redirect('/now-test'); //flash value will be available in next request but not in current request
});

Route::get('/now-test', function () {
    return view('now');
});

Route::get('/session-data', function (Request $request) {
    return [];
});

Route::get('set-sessions', function (Request $request) {
    return [
        'countries-using-put' => $request->session()->put(['countries', ['India', 'USA', 'UK']], ['company-name' => []]),
        'domain-using-session' => session(['domain' => 'Website']),
        //'company-name-using-push' => $request->session()->push('company-name', 'ABC')

    ];
});

//$request-session()->get('company-name')
//$request->session()-get('section','223GT')
//session('domain')
//&request->session()->all()
//$request->session()->has('section')
//$request->session()->exists('section')

Route::get('/get-session', function (Request $request) {
    return [
        'get' => $request->session()->get('company-name'),
        'domain-using-session' => session('domain'),
        'default-value' => $request->session()->get('section', '223GT'),
        'all-session' => $request->session()->all(),
        'has-section' => $request->session()->has('countries') ? 'true' : 'false',
        'exists-section' => $request->session()->exists('section') ? 'true' : 'false',
    ];
});

//$request->session()->forget('company-name')
//$request->session()->forget(['company-name','section'])
//$request->session()->flush() //delete all session data
//$request->session()->pull('company-name') //get value and delete from session

Route::get('/delete-session', function (Request $request) {
    return [
        'forget' => $request->session()->forget('company-name'),
        'forget-multiple' => $request->session()->forget(['company-name', 'section']),
        'flush' => $request->session()->flush(),
        'pull' => $request->session()->pull('countries'),
    ];
});

// Route::get('/lang/{locale}', function ($locale) {

//     $availableLocales = ['en', 'hi', 'pa'];

//     if (!in_array($locale, $availableLocales)) {
//         abort(404);
//     }

//     app()->setLocale($locale);
//     session()->put('locale', $locale);

//     return view('lang');
// });

Route::get('/lang/{locale}',function($locale){
    Session::put('locale',$locale);
    return redirect('languange');
});
Route::view('/languange','home');







Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/lang/{locale}', function ($locale) {

    $availableLocales = ['en', 'hi', 'pa', 'fr'];

    if (!in_array($locale, $availableLocales)) {
        abort(404);
    }

    session()->put('locale', $locale);

    return redirect()->back();
});

Route::get('/form', [FormController::class, 'showForm']);
Route::post('/submit-form', [FormController::class, 'submitForm']);



use App\Http\Controllers\ProductController;
//Route::show('/products', [ProductController::class, 'index'])->name('products.index');
Route::resource('Product', ProductController::class);