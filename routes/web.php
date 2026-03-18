<?php

use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\ProductController;
// use App\Http\Controllers\StudentController;
// use App\Http\Controllers\CourseController;
// use App\Http\Controllers\LoginController;

// Route::get('/welcome', function () {
//     return view('welcome');
// });

// Route::get('/hello', function () {
//     return view('hello');
// });

// Route::get('/hi', function()
// {
//     return view('hi');
// });

// Route::get('cal/{id1}/{id2}/{op}',function($id1, $id2, $op)
// {
//     if($op == 'add')
//     {
//         return 'Add '.$id1 + $id2;
//     }
//     else if($op == 'sub')
//     {
//         return 'Sub '.$id1 - $id2;
//     }
//     else if($op == 'mul')
//     {
//         return 'Mul '.$id1 * $id2;
//     }
//     else if($op == 'div')
//     {
//         return 'Div '.$id1 / $id2;
//     }
// });


// Route::get('/product', [ProductController::class, 'index']);

// Route::get('/student/{name}', [StudentController::class, 'index']
// );


// Route::get('/course/{course?}', [CourseController::class, 'index']
// );


// Route::get('/login/{email}/{password}', function($email, $password)
// {
//     if($email == 'salil@gmail.com' && $password == '12345')
//     {
//         // redirect to dashboard
//         return redirect('/dashboard')
//         ->with('email', $email)
//         ->with('password', $password)
//         ->with('success', 'Login Successful');
//     }
//     else
//     {
//         return 'Login Failed';
//     }
// });

// Route::get('/dashboard', function()
// {
//     return view('dashboard');
// })->name('dashboard');

Route::prefix('admin')->group(function()
{
    Route::get('/login', function()
    {
        return '<h1>Welcome to admin login page</h1>';
    })->name('admin.login');

    Route::get('/dashboard', function()
    {
        return '<h1>Welcome to admin dashboard</h1>';
    })->name('admin.dashboard');
});