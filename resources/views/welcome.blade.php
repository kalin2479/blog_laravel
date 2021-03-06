@extends('layout')
@section('meta-title')
	Mi Blog
@endsection
@section('meta-description')
  Descripcion de inicio del Blog
@endsection
@section('content')
	<section class="posts container">
		@if (isset($title))
			<h3>{{ $title }}</h3>
		@endif
		@foreach($posts as $post)
		<article class="post">
			@if ($post->photos->count() === 1)
				<!-- Si es igual a 1, es decir si tenemos una sola imagen hacemos aparecer -->
				<figure><img src="{{ $post->photos->first()->url }}" alt="" class="img-responsive"></figure>
			@elseif($post->photos->count() > 1)
				<div class="gallery-photos masonry">
					@foreach($post->photos->take(4) as $photo)
						<!-- take(4)-> indicamos que deseamos solo los 4 primeros elementos -->
						<!-- url() -> es para llamar a la ruta absoluta, sin eso invoca a la relativa -->
						<figure class="gallery-image" style="overflow:hidden">
							@if($loop->iteration === 4)
								<div class="overlay">
									{{ $post->photos->count() }} Fotos
								</div>
							@endif
							<img src="{{ url($photo->url) }}" alt="">
						</figure>
					@endforeach
				</div>
			@elseif ($post->iframe)
				<div class="video">
					{{-- hacemos de esta manera por que vamos a imprimir html como tal --}}
					{!! $post->iframe !!}
				</div>
			@endif
			<div class="content-post">
				<header class="container-flex space-between">
					<div class="date">
						<!-- diffForHumans() -->
						<span class="c-gray-1">{{ $post->published_at->format('M d') }}</span>
					</div>
					<div class="post-category">
						<span class="category text-capitalize">
							<a href="{{ route('categories.show', $post->category)}}">{{ $post->category->name}}</a>
						</span>
					</div>
				</header>
				<h1>{{ $post->title }} </h1>
				<div class="divider"></div>
				<p>{{ $post->excerpt }}</p>
				<footer class="container-flex space-between">
					<div class="read-more">
						<a href="blog/{{ $post->url }}" class="text-uppercase c-green">read more</a>
					</div>
					<div class="tags container-flex">
						@foreach($post->tags as $tag)
							<span class="tag c-gray-1 text-capitalize"><a href="{{ route('tags.show',$tag) }}">#{{ $tag->name }}</a></span>
						@endforeach
					</div>
				</footer>
			</div>
		</article>
		@endforeach
	</section><!-- fin del div.posts.container -->
	{{ $posts->links() }}
@endsection
