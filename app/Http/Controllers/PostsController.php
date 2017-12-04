<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    //public function show($id)
    /*
    si se agrea el modelo post nos traira el POST con el ID  que le
    estamos pasando
    */
    public function show(Post $post)
    {

      //$post = Post::find($id);

      return view('posts.show',compact('post'));
    }
}
