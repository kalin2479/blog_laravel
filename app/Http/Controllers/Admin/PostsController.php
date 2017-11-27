<?php

namespace App\Http\Controllers\Admin;

use App\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    //
    public function index()
    {
        $posts = Post::all();
        /*
        * compact -> nos ayuda pasar la variable a la vista 
        */
        return view('admin.posts.index', compact('posts'));
    }
}
