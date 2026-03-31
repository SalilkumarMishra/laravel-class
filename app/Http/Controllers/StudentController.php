<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function students()
    {
        return 'This is my students function of student controller';
    }
    public function profile()
    {
        $data=[
            'name' => 'Salil',
            'age' => 21,
            'course' => 'Laravel'
        ];
        return $data;
    }
    public function student($name)
    {
        return view ('student' , ['name' => $name]);
    }
    public function course($course = 'No Course')
    {
        return view ('course', ['course' => $course]);
    } 
}
