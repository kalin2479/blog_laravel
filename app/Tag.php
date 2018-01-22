<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // le pasamos un array vacio para desactivar la asigancion masiva
    protected $guarded = [];
    
    public function getRouteKeyName()
    {
        return 'url';
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    // Colocamos nuestro mutador

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['url'] = str_slug($name);
    }
}
