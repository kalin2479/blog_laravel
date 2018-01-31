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
        // vamos a guardarlo en una subcarpeta llamada post como primer parametro
        // como segundo parametro el disco como tenemos definido en la configuracion
        $photo = $photo->store('posts','public');
        // para poder acceder a las imagenes que se guardar en la carpeta store/app/public
        // demos crear un simbolic link, para ello artisan nos provee el siguiente comoando.
        // php artisan storage:link
        // luego para utilizar la url correcta llamamos al siguiete metodo: Storage::url
        $photoUrl = Storage::url($photo);

        // almacenamos la imagen
        // Photo::create([
        //     'url' => $photoUrl,
        //     'post_id' => $post->id
        // ]);

        // Otra forma de crear una foto sin necesidad de pasarle el id del post es de la siguiente manera

        // Utilizamos la variable post para acceder a la relacion photos y creamos una nueva foto,
        // para crear esta nueva foto solo necesitamos la url ya que el post_id est implicito al guardarlo de
        // esta forma

        $post->photos()->create([
            'url' => $photoUrl
        ]);

        // return $photoUrl;
    }

    public function destroy(Photo $photo)
    {
        // eliminamos el registro de la base de datos

        // Ahora como parte de la mejora lo que vamos hacer es que cuando se elimine una foto  desde la base de datos con elocuent
        // inmediatamente se elimine la foto a la que hace referencia. Para ello utilizaremos el modelo foto.
        $photo->delete();
        
        return back()->with('flash','Foto eliminada');
    }
}
