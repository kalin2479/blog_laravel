<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// Importamos la libreria Facades.
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    // vamos a deshabilitar la proteccion con asignacion masiva
    // ya que estamos siendo especifico con los campos
    protected $guarded = [];

    // Para ello vamos a sobreescribir el metodo estatico boot

    protected static function boot(){
        // Antes que nada debemos ejecutar el metodo boot del padre del cual hereda este metodo.
        parent::boot();
        // Ahora podemos decir que cuando estemos elimando pasamos una funcion para que se ejecute lo siguiente, para ello utilizamos
        // la funcion estatica deleting (ahi escuchamos cuando se elimine una foto)
        static::deleting(function($photo){
            // reemplazamos storage por public para poder borrar la imagen del servidor
            //return $photo->url;
            // $photoPath = str_replace('storage','public',$photo->url);
            // En esta mejora lo que debemos hacer es reemplazar la palabra /storage/ por vacio para luego procesar el borrado de manera correcta

            $photoPath = str_replace('/storage/','',$photo->url);

            // Para elimniar un archivo utilizamos storage delete
            // que recibe por parametro la ubicacion del archivos
            // Storage::delete($photoPath);
            // Ahora debemos indicar que debe borrar el archivo que se encuentra dentro de una subcarpeta llamada post que esta dentro
            // de la carpeta public
            Storage::disk('public')->delete($photoPath);
        });

    }
}
