<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    // vamos a deshabilitar la proteccion con asignacion masiva
    // ya que estamos siendo especifico con los campos
    protected $guarded = [];
}
