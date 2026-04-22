<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PostController;

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


Route::get('url-generation',function(){
    return [
        'current'=>url()->current(),
        'current-with-request'=>request()->current(),
        'fullURL-with-request'=>request()->fullUrl(),
        'fullURL'=>url()->full(),
        'path'=>request()->path(),
        'previous'=>url()->previous(),
        'url'=>url('/home',['id'=>3]),
        'route'=>route('AB'),
        'action'
        ];
});