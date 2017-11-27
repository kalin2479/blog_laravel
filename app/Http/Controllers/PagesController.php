<?php

namespace App\Http\Controllers;

/*
* Vamos a importar el App correspondiente 
*/
use App\Post;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home($value='')
    {
        // estamos ordenando por la fecha de publicacion, en caso de no poner nada
        // se ordena por la fecha de creacion
        $posts = Post::latest('published_at')->get();

        // le pasamos a la plantilla para le pasamos una variable y su valor
        //return view('welcome')->with('posts', $posts);
        // otra forma de hacerlo es la siguiente
        return view('welcome', compact('posts'));
    }
}
