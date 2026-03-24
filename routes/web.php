<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
// use App\Http\Controllers\ProductController;
use App\Http\Controllers\StudentController;
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

// Route::prefix('admin')->group(function()
// {
//     Route::get('/login', function()
//     {
//         return '<h1>Welcome to admin login page</h1>';
//     })->name('admin.login');

//     Route::get('/dashboard', function()
//     {
//         return '<h1>Welcome to admin dashboard</h1>';
//     })->name('admin.dashboard');
// });

// Route::get('/dashboard', function()
// {
//     return response()->json([
//         'name' => 'Salil',
//         'Id' => 12345
//     ])
//     ->header('Content-Type', 'application/json')
//     ->header('X-Custom-Header', 'Laravel');
// });

Route::get('set-cookie', function()
{
    return response("Cookie Set Successfully")
        ->cookie('name', 'Salil', 60); // 60 minutes
});

Route::get('read-cookie', function(Request $request)
{
    $name = $request->cookie('name');
    return "Cookie Value: " . $name;
});

// Route::get('new-url/{name}', [StudentController::class, 'students']);

// Route::get('/login', function() {
//     return redirect()->action([StudentController::class, 'students'], ['name' => 'Salil']);
// });

Route::get('/dashboard', function() {
    return view('dashboard');
})->name('AB');
Route::get('/login/{email}/{password}', function($email, $password) {
    if($email == 'salil@gmail.com' && $password == '12345')
    {
        return redirect()->route('AB')->with('email', $email)->with('password', $password)->with('success', 'Login Successful');
    }
    else
    {
        return 'Login Failed';
    }
});