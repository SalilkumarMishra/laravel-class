<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = [
            ['title' => 'First Post'],
            ['title' => 'Second Post'],
            ['title' => 'Third Post'],
        ];

        return view('post.index', compact('posts'));
    }
}