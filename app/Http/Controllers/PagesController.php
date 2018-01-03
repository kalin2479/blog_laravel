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
        // Para paginar lo que hacemos es en ver de llamar
        // al metodo get llamamos al metodo paginate, si note
        // le pasamos ningun parametro lo hara de 15 en 15
        // Para obtener el php de paginacion hacemos la siguiente instruccion
        // php artisan vendor:publish --tag=laravel-pagination

        // Otra forma de paginacion
        // Es: simplePaginate(numero de item a mostros)
        // $posts = Post::publishead()->get();
        $posts = Post::publishead()->paginate(3);
        // $posts = Post::publishead()->simplePaginate(2);

        // le pasamos el nombre de la plantilla
        // Luego una variable y su valor
        //return view('welcome')->with('posts', $posts);
        // otra forma de hacerlo es la siguiente
        return view('welcome', compact('posts'));
    }
}
