<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Storage;

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