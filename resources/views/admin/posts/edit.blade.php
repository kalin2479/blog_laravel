@extends('admin.layout')

@section('header')
    <h1>
        Post
        <small>Editar</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="{{ route('admin.posts.index') }}"><i class="fa fa-list"></i> Posts</a></li>
        <li class="active">Editar</li>
    </ol>
@stop

@section('content')
    <div class="row">
        @if ($post->photos->count())
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            @foreach ($post->photos as $photo)
                                <form method="POST" action="{{ route('admin.photos.destroy',$photo) }}">
                                    {{ method_field('DELETE') }} {{ csrf_field() }}
                                    <div class="col-md-2">
                                        <button class="btn btn-danger btn-xs" style="position:absolute">
                                            <i class="fa fa-remove"></i>
                                        </button>
                                        <img src="{{ url($photo->url) }}" class="img-responsive" alt="" />
                                    </div>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <form method="POST" action="{{ route('admin.posts.update', $post) }}" >
            {{ csrf_field() }} {{ method_field('PUT') }}
            <!-- method_field('PUT'), nos sirve para indicar que estamos enviando los datos por el metodo put -->
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="">Titulo de la publicacion</label>
                            <input type="text"
                            class="form-control"
                            value="{{ old('title', $post->title) }}"
                            name="title"
                            placeholder="Ingresa aqui el titulo de la publicacion">
                            <!--!! !! se utiliza esa sintaxis cuando estamos seguros del html que estamos inyectando -->
                            {!! $errors->first('title', '<span class="help-block">:message</span>') !!}

                        </div>
                        <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                            <label for="">Contenido de la publicacion</label>
                            <textarea rows="10" name="body" id="editor" class="form-control" placeholder="Ingresa el contenido de la publicacion">{{ old('body',$post->body) }}</textarea>
                            {!! $errors->first('body', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('iframe') ? 'has-error' : '' }}">
                            <label for="">Contenido embebido (iframe)</label>
                            <textarea rows="2" name="iframe" id="editor" class="form-control" placeholder="Ingresa el iframe del video o audio">{{ old('iframe',$post->iframe) }}</textarea>
                            {!! $errors->first('iframe', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">fecha de publicacion:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text"
                                class="form-control pull-right"
                                name="published_at"
                                value="{{ old('published_at', $post->published_at ? $post->published_at->format('m/d/Y') : null) }}"
                                id="datepicker" >
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                            <label for="">Categorias </label>
                            <select class="form-control select2" name="category">
                                <option value="">Selecciona una categoria</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category', $post->category_id) == $category->id ? 'selected' : '' }}
                                        >{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('category', '<span class="help-block">:message</span>') !!}

                            </div>
                            <div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
                                <div class="form-group">
                                    <label>Etiquetas </label>
                                    <select
                                    name="tags[]"
                                    class="form-control select2"
                                    multiple="multiple"
                                    data-placeholder="Selecciona una o mas etiquetas"
                                    style="width: 100%;">
                                    @foreach ($tags as $tag)
                                        <option {{ collect(old('tags', $post->tags->pluck('id')))->contains($tag->id) ? 'selected' : '' }} value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('tags', '<span class="help-block">:message</span>') !!}

                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('excerpt') ? 'has-error' : '' }}">
                            <label for="">Extracto de la publicacion</label>
                            <textarea name="excerpt"
                            class="form-control"
                            placeholder="Ingresa un extracto de la publicacion">{{ old('excerpt', $post->excerpt) }}</textarea>
                            {!! $errors->first('excerpt', '<span class="help-block">:message</span>') !!}

                        </div>
                        <div class="form-group">
                            <div class="dropzone">

                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block" name="button">Guardar publicacion</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>


@stop
<!-- Para utilizar el stack llamamos al comando push quien hara el trabajo de -->
<!-- agregar los script correspondientes-->
<!-- bootstrap datepicker -->
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/dropzone.css">
    <link rel="stylesheet" href="/adminlte/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/adminlte/select2/dist/css/select2.min.css">
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/min/dropzone.min.js"></script>
    <!-- CK Editor -->
    <script src="/adminlte/ckeditor/ckeditor.js"></script>
    <script src="/adminlte/ckeditor/initialCkeditor.js"></script>
    <!-- bootstrap datepicker -->
    <script src="/adminlte/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- Select2 -->
    <script src="/adminlte/select2/dist/js/select2.full.min.js"></script>
    <script type="text/javascript">
    $('#datepicker').datepicker({
        autoclose: true
    });
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    initConfig();
    $('.select2').select2({
        tags : true
    });

    // Configuracion del Dropzone
    // El 2 parametro es de configuracion
    // Si no le colocamos parametros dropzone aceptara cualquier tipo de archivo
    // acceptedFiles image/* -> solo permitira archivos que sean imagenes
    // maxFilesize -> la restriccion es en MB
    // paramName-> cambiamos el nombre file que viene por defecto, el cual
    // es cuando vamos a procesar la informacion
    var myDropzone = new Dropzone('.dropzone',{
        url: '/admin/posts/{{ $post->url }}/photos',
        acceptedFiles: 'image/*',
        paramName: 'photo',
        maxFilesize: 2,
        //maxFiles: 1,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dictDefaultMessage: 'Arrastra las fotos aqui para subirlas'
    });

    // Cremos una variable para escuchar los eventos y procesar la informacion
    myDropzone.on('error', function(file,res){
        var msg = res.photo[0];
        //last -> que le cambie el mensaje al ultimo elemento que cumpla
        // con estas condiciones
        $('.dz-error-message:last > span').text(msg);
    });
    // Aqui vamos a indicar a DRopzone que no lo inicialice de manera automatica

    Dropzone.autoDiscover = false;

    </script>
@endpush
