<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // lo que hacemos haciendo es darle formato de fecha para poder usar todas las propiedades
    protected $dates = ['published_at'];

    // con esta funcion lo que estamos haciendo es relacionar de 1 a muchos
    // una categoria puede contener 1 o mas posts
    public function category()
    {
        return $this->belongsTo(Category::class); // pertenece a
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class); // relacion de muchos a muchos
    }
}
