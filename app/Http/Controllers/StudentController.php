<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function students($name)
    {
        return view ('student' , ['name' => $name]);
    }
}
