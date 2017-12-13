<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class PhotosController extends Controller
{
    public function store(Post $post)
    {
      // por lo general este valor debe ser menor que el valor
      // definido en el php.ini
      $this->validate(request(), [
        'photo' => 'required|image|max:2048' // jpge png bmp gif svg
      ]);
      // request()->all -> con este metodo vemos todo lo que trae
      // request()->file -> con este metodo accedemos al archivo
      $photo = request()->file('photo');

      // va a  guardar la imagen en la carpeta storage/app
      // pero podemos indicarle que lo guarde en la carpeta public de ahi dentro
      // de la siguiente manera ('public') o con otro nombre
      // eso nos devolvera la direccion url de la imagen.
      $photo = $photo->store('public');
      // para poder acceder a las imagenes que se guardar en la carpeta store/app/public
      // demos crear un simbolic link, para ello artisan nos provee el siguiente comoando.
      // php artisan storage:link
      // luego para utilizar la url correcta llamamos al siguiete metodo: Storage::url
      $photoUrl = Storage::url($photo);

      // almacenamos la imagen
      Photo::create([
        'url' => $photoUrl,
        'post_id' => $post->id
      ]);

      return $photoUrl;
    }
}
