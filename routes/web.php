<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;

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

Route::get('/student/{name}', [StudentController::class, 'index']
);


Route::get('/course/{course?}', [CourseController::class, 'index']
);

