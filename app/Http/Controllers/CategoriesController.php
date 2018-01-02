<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category)
    {
        return $category;
        // este welcome recibe los posts y tenemos que filtrarlo
        return view('welcome',compact('posts'));
    }
}
