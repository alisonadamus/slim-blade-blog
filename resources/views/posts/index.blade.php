@extends('home')

@section('title', 'Список постів')

@section('content')
    <h1>Пости</h1>
    @if(isset($_SESSION['user_id']))
        <a href="/posts/create" class="btn btn-primary">Створити новий пост</a>
    @endif

    @if($posts->isNotEmpty())
        <ul class="list-group mt-3">
            @foreach($posts as $post)
                <li class="list-group-item">
                    <h3>{{ $post->title }}</h3>
                    @if($post->tags->isNotEmpty())
                        <p>Теги:
                            @foreach($post->tags as $tag)
                                <span class="badge bg-secondary">{{ $tag->name }}</span>
                            @endforeach
                        </p>
                    @endif
                    <a href="/posts/{{ $post->id }}" class="btn btn-primary">Читати далі</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>Наразі немає постів.</p>
    @endif
@endsection
