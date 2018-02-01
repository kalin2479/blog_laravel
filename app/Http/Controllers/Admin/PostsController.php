<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Category;
use Carbon\Carbon;
use App\Tag;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;

class PostsController extends Controller
{
    // En los controladores solo deberian estar los metodos de las acciones request, las cuales son:
    // - index
    // - show
    // - create
    // - store
    // - edit
    // - update
    // - destroy
    // Esto es lo recomendable
    public function index()
    {
        $posts = Post::all();
        /*
        * compact -> nos ayuda pasar la variable a la vista
        */
        return view('admin.posts.index', compact('posts'));
    }
    /*
    public function create()
    {
    $categories = Category::all();
    $tags = Tag::all();
    return view('admin.posts.create',compact('categories', 'tags'));
    }
    */
    public function store(Request $request)
    {
        $this->validate($request, ['title' => 'required']);

        // Ahora tenemos de esta manera por que estamos utilizando mutadores para la url
        // Al hacer un only nos devolvera un array con la llave title y el valor del titulo que ingresamos
        // por el formulario y va ignorar el resto de campos
        $post = Post::create($request->only('title'));

        // $post = Post::create([
        //     'title' => $request->get('title'),
        //     'url' => str_slug($request->get('title'))
        // ]);

        return redirect()->route('admin.posts.edit',$post);
    }
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit',compact('categories', 'tags', 'post'));
        //return view('admin.posts.edit', compact('post'));
    }

    // public function update(Post $post, Request $request)
    // Para indicarle al controlador que utilize este clase lo que hacemos es inyectar el StorePostRequest (que es nuestro request que hemos creado)
    //[no olvidemos importar la clase completa arriba]
    // en vez del Request
    public function update(Post $post, StorePostRequest $request)
    {
        //return $request->all();
        // Lo que vamos es hacer una restructuracion de nuestro codigo
        // Para ello vamos a utilizar request, y creamos uno para la validacion de
        // la siguiente manera: php artisan make:request StorePostRequest [esto es como : solicutd para
        // almacenar un post] con lo cual la validacion se ejecutara de manera automatica.

        //return Post::create($request->all());
        // dd -> funciona como var_dump mas die()
        //dd($request->get('tags'));
        /*
        Recuerda que cuando queremos actualizar un registro
        no debemos crear el objeto.
        $post = new Post;
        Solo proceder a ejecutar los metodos del objeto por
        que ya esta creado
        */

        // Ahora como los campos coinciden con los atributos podemos hacer uso
        // del metodo update de elocuent

        // $post->title = $request->get('title');
        // Ahora tenemos de esta manera por que estamos utilizando mutadores para la url
        //$post->url = str_slug($request->get('title'));
        // $post->body = $request->get('body');
        // $post->iframe = $request->get('iframe');
        // $post->excerpt = $request->get('excerpt');

        // Para el caso de la fecha haremos uso de los mutadores, lo cual ya vimos anteriormente
        // para ello abrimos el modelo post y creamos una funcion
        // $post->published_at = $request->has('published_at')
        //                                     ? Carbon::parse($request->get('published_at'))
        //                                     : null;
        // En vez de preguntar si existe published_at simplemente obtenemos su valor.

        // $post->published_at = $request->get('published_at');

        // Originalmente nosotros solo recibiamos id, pero ahora podemos recibir nombre de etiquetas
        // para que puedan ser insertadas en la base de datos
        // Vamos hacer Category::find($valor) -> indica que si es encontrada recibimos un id caso contrario
        // debemos hacer un insertar
        // Category::create(['name' => $cat])->id -> es para obtener el id de la categoria recien creada
        // $post->category_id = Category::find($cat = $request->get('category'))
        //                         ? $cat
        //                         : Category::create(['name' => $cat])->id;

        // De igual manera crearemos un mutador para la categoria
        // $post->category_id = $request->get('category_id');
        // $post->save();
        // Aplicando el metodo update de elocuent el metodo update debe recibir un array
        // si lo dejamos asi no va a funcionar por que me pide que no existe una columna Tags en la tabla post
        // $post->update($request->all());
        // Para ello utilizamos el except en el cual podemos indicar que queremos el request menos llave tags
        // De esta manera estamos siendo vulnerables contra ataques de asignación masiva, debemos cambiar el protect por filletable
        // ej alguien podria enviar el id del formulario y cambiar el identificador del post lo que causaria inconsistencia BD
        // $post->update($request->except('tags'));
        // Ahora si podemos utilizar el all por que estamos utilizando $fillable,
        // dado que va ignorar el resto de campos que no esten definidos en el fillable
        $post->update($request->all());


        // Otra cosa que podemos hacer es extraer esta logica a un metodo del post y lo podemos hacer de la siguiente manera
        // y le pasamos las etiquetas
        $post->syncTags($request->get('tags'));
        // para el caso de las etiquetas vamos hacer lo siguiente
        // $tags = [];
        // foreach ($request->get('tags') as $tag) {
        //     // Lo que hacemos es encontrar la etiqueta similar a lo que hicimos con la categoria
        //     $tags[] = Tag::find($tag) ? $tag : Tag::create(['name' => $tag])->id;
        // }

        /*
        Hacemos el cambio con redirect para que cuando cambiemos el titulo
        no se pierda la url.
        Eso sucede porque todavia esta procesando la infomacion con el titulo
        anterior y no con el nuevo titulo que se ha colcado
        */
        return redirect()->route('admin.posts.edit', $post)->with('flash', 'Tu publicacion ha sido guardada');
        //return back()->with('flash', 'Tu publicacion ha sido guardada');
    }
    public function destroy(Post $post )
    {
        // Antes de eliminar el post accedemos al tags para eliminar todas las relaciones que puedan haber
        // Lo que hacemos es llamar al metodo detach lo cual hará es elimnar todas las relaciones que existen con este post.
        // se usa para la relacion de muchos a muchos
        $post->tags()->detach();

        //Ahora vamos ha aceeder a la relacion fotos y procederemos a borrar.

        $post->photos()->delete();

        $post->delete();
        return redirect()->route('admin.posts.index')->with('flash', 'La publicacion ha sido eliminada');

    }
    /* Metodo nos servia para la creacion de un post
    public function store(Request $request)
    {
    // validacion
    // validate se encuentra de la clase controller a la cual accedemos
    // de la siguiente manera
    $this->validate($request,[
    'title'     => 'required',
    'body'      => 'required',
    'category'  => 'required',
    'excerpt'  => 'required',
    'tags'  => 'required'
    ]);
    //return Post::create($request->all());
    // dd -> funciona como var_dump mas die()
    //dd($request->get('tags'));
    $post = new Post;
    $post->title = $request->get('title');
    $post->url = str_slug($request->get('title'));
    $post->body = $request->get('body');
    $post->excerpt = $request->get('excerpt');
    $post->published_at = $request->has('published_at') ? Carbon::parse($request->get('published_at')) : null;
    $post->category_id = $request->get('category');
    $post->title = $request->get('title');
    $post->save();

    //etiquetas
    $post->tags()->attach($request->get('tags'));

    return back()->with('flash', 'Tu publicacion ha sido creada');
    }*/
}
