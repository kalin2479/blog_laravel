<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // le pasamos un array vacio para desactivar la asigancion masiva
    protected $guarded = [];

    // lo que hacemos haciendo es darle formato de fecha para poder usar todas las propiedades
    protected $dates = ['published_at'];
    /*
      Para las url amigables vamos a sobreescribir el metodo getRouteKeyName
      y retornamos el nombre del campo por el cual queremos encontrarlo
    */
    public function getRouteKeyName()
    {
      return 'url';
    }

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

    public function photos()
    {
      // definimos la relacion de uno a muchos
      return $this->hasMany(Photo::class);
    }

    public function scopePublishead($query)
    {
      // la sintaxis es colocar en minuscula la palabra scope a;adiendo la
      // palabra que vamos a llamar a este, recuerda q su primera letra es mayuscula
      // nos permite crear querys para poderlos reutilizar nuevamente

      // estamos ordenando por la fecha de publicacion, en caso de no poner nada
      // se ordena por la fecha de creacion
      //whereNotNull -> estamos validando que la fecha de publicacion sea diferente de null
      // ademas se debe publicar solo los post que sea igual o menor a la fecha de hoy
      $query->whereNotNull('published_at')
                ->where('published_at', '<=', Carbon::now())
                ->latest('published_at');

    }
}
