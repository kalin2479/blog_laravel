<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category)
    {
        // return $category->load('posts');
        // pero nosotros necesitamos llamar solo los post de manera independiente
        // return $category->posts;
        // este welcome recibe los posts y tenemos que filtrarlo
        // return view('welcome',compact('posts'));
        // pasamos un array con la llave posts
        // Lo que estamos haciendo es enviar a la vista welcome un array con los posts
        // pertencen a esa categoria.
        // tenemos que pasar paginate() porque estamos paginando sino nos saldra un error de links
        return view('welcome',[
            'category' => $category,
            'posts' => $category->posts()->paginate(1)
        ]);

    }
}
