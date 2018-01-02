<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Category;
use Carbon\Carbon;
use App\Tag;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    //
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

      $post = Post::create([
        'title' => $request->get('title'),
        'url' => str_slug($request->get('title'))
      ]);

      return redirect()->route('admin.posts.edit',$post);
    }
    public function edit(Post $post)
    {
      $categories = Category::all();
      $tags = Tag::all();
      return view('admin.posts.edit',compact('categories', 'tags', 'post'));
      //return view('admin.posts.edit', compact('post'));
    }

    public function update(Post $post, Request $request)
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
      /*
        Recuerda que cuando queremos actualizar un registro
        no debemos crear el objeto.
        $post = new Post;
        Solo proceder a ejecutar los metodos del objeto por
        que ya esta creado
      */
      $post->title = $request->get('title');
      $post->url = str_slug($request->get('title'));
      $post->body = $request->get('body');
      $post->iframe = $request->get('iframe');
      $post->excerpt = $request->get('excerpt');
      $post->published_at = $request->has('published_at') ? Carbon::parse($request->get('published_at')) : null;
      $post->category_id = $request->get('category');
      $post->title = $request->get('title');
      $post->save();

      //etiquetas
      // sync -> para evitar duplicidad de etiquetas
      // attach -> cuando coloco este metodo me esta generando duplicidad en la BD
      $post->tags()->sync($request->get('tags'));
      /*
        Hacemos el cambio con redirect para que cuando cambiemos el titulo
        no se pierda la url.
        Eso sucede porque todavia esta procesando la infomacion con el titulo
        anterior y no con el nuevo titulo que se ha colcado
      */
      return redirect()->route('admin.posts.edit', $post)->with('flash', 'Tu publicacion ha sido guardada');
      //return back()->with('flash', 'Tu publicacion ha sido guardada');
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
