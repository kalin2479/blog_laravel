@extends('admin.layout')

@section('header')
<h1>
    Post
    <small>Crear</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
  <li><a href="{{ route('admin.posts.index') }}"><i class="fa fa-list"></i> Posts</a></li>
  <li class="active">Crear</li>
</ol>
@stop

@section('content')
  <div class="row">
    <form method="POST" action="{{ route('admin.posts.store') }}" >
      {{ csrf_field() }}
      <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-body">
              <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                  <label for="">Titulo de la publicacion</label>
                  <input type="text"
                      class="form-control"
                      value="{{ old('title') }}"
                      name="title"
                      placeholder="Ingresa aqui el titulo de la publicacion">
                  <!--!! !! se utiliza esa sintaxis cuando estamos seguros del html que estamos inyectando -->
                  {!! $errors->first('title', '<span class="help-block">:message</span>') !!}

              </div>
              <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                  <label for="">Contenido de la publicacion</label>
                  <textarea rows="10" name="body" id="editor" class="form-control" placeholder="Ingresa el contenido de la publicacion">{{ old('body') }}</textarea>
                  {!! $errors->first('body', '<span class="help-block">:message</span>') !!}
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
                  value="{{ old('published_at') }}"
                  id="datepicker" >
              </div>
            </div>
            <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                <label for="">Categorias</label>
                <select class="form-control" name="category">
                  <option value="">Selecciona una categoria</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category') == $category->id ? 'selected' : '' }}
                    >{{ $category->name }}</option>
                  @endforeach
                </select>
                {!! $errors->first('category', '<span class="help-block">:message</span>') !!}

            </div>
            <div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
              <div class="form-group">
                <label>Etiquetas</label>
                <select
                        name="tags[]"
                        class="form-control select2"
                        multiple="multiple"
                        data-placeholder="Selecciona una o mas etiquetas"
                        style="width: 100%;">
                  @foreach ($tags as $tag)
                    <option {{ collect(old('tags'))->contains($tag->id) ? 'selected' : '' }} value="{{ $tag->id }}">{{ $tag->name }}</option>
                  @endforeach
                </select>
                {!! $errors->first('tags', '<span class="help-block">:message</span>') !!}

              </div>
            </div>
            <div class="form-group {{ $errors->has('excerpt') ? 'has-error' : '' }}">
                <label for="">Extracto de la publicacion</label>
                <textarea name="excerpt"
                      class="form-control"
                      placeholder="Ingresa un extracto de la publicacion">{{ old('excerpt') }}</textarea>
                {!! $errors->first('excerpt', '<span class="help-block">:message</span>') !!}

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
  <link rel="stylesheet" href="/adminlte/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="/adminlte/select2/dist/css/select2.min.css">
@endpush
@push('scripts')
  <!-- CK Editor -->
  <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
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
    CKEDITOR.replace('editor');
    $('.select2').select2();
  </script>
@endpush
