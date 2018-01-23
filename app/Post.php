<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // le pasamos un array vacio para desactivar la asigancion masiva
    // protected $guarded = [];
    // Para proteger de la asignacion masiva y definiremos los unicos
    // campos que se puedan asignar masivamente
    // De ahora en adelante no importa cuantos atributos pasen por el formulario, solo estos
    // se actualizaran realmente
    protected $fillable = [
        'title', 'body', 'iframe', 'excerpt', 'published_at', 'category_id',
    ];

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

    // Creamos un mutador para las url amigables y no estar generando codigo repetido
    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = $title;
        $this->attributes['url'] = str_slug($title);
    }

    // Creamos una funcion para setear o mutar el atributo published_at
    public function setPublishedAtAttribute($published_at)
    {
        //echo $published_at; die();
        $this->attributes['published_at'] = $published_at ? Carbon::parse($published_at) : null;
    }
    public function setCategoryIdAttribute($category)
    {
        $this->attributes['category_id'] = Category::find($category) ? $category : Category::create(['name' => $category])->id;
    }

    // Creamos el metodo para las etiquetas
    public function syncTags($tags)
    {
        // Para el caso de las etiquetas utilizaremos colecciones y utilizaremos maps
        // con lo cual iremos recibiendo las etiquetas una a la vez
        $tagIds = collect($tags)->map(function($tag){
            return Tag::find($tag) ? $tag : Tag::create(['name' => $tag])->id;
        });
        // Finalmente lo que hacemos es sincronizar con el array de tareas de la siguiente manera
        return $this->tags()->sync($tagIds);
        //etiquetas
        // sync -> para evitar duplicidad de etiquetas
        // attach -> cuando coloco este metodo me esta generando duplicidad en la BD
        // $post->tags()->sync($request->get('tags'));
    }
}
