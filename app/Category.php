<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // le pasamos un array vacio para desactivar la asigancion masiva
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'url';
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

  // Ahora aplicaremos como usar un accesor
  // para ello se denota de la siguiente manera :
  // get[nombre que se desea]Attribute(parametro){}
  // Es asi como se define un accesor
  // Ahora por parametro obtenemos la propiedad a la cual queremos
  // acceder y finalmente retirnamos la modificacion que se quiere.
  // public function getNameAttribute($name)
  // {
  //   // str_slug lo que hace es convertirlo a un url amigable
  //   return str_slug($name);
  // }

  // Ahora vamos a definir un mutador, para hacerlo es muy similar al accesor
  // solo que con la variante set...
  // Este se ejecutará antes de guardar el modelo
  // Lo que deseamos es mutar o transformar el atributo name sin caracteres especiales
  // ni espacios , el nombre queremos  que se guarde en el campos nombre sin modificaciones
  // pero como parte de proceso de guardar el nombre queremos quye se modificque otro atributo
  // el cual seria url
  public function setNameAttribute($name)
  {
    // accedemos a los atributos en este caso al name
    // esto quiere decir que el valor name que estemos tratando
    // de ingresar lo va a transformar y finalmente lo va guardar
    // en la instancia de elocuent.
    $this->attributes['name'] = $name;
    $this->attributes['url'] = str_slug($name);
  }
}
