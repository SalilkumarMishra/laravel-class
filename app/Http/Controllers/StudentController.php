<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function index($name)
    {
        return view ('student' , ['name' => $name]);
    }
}
