<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class CourseController extends Controller
{
    //
    public function index($course = null)
    {
        return view ('course', ['course' => $course]);
    }
}