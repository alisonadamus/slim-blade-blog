@extends('home')

@section('title', 'Перегляд поста')

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>Опис: {{ $post->content }}</p>
    <p>Автор: {{ $post->user->name }}</p>

    @if($post->tags->isNotEmpty())
        <p>Теги:
            @foreach($post->tags as $tag)
                <span class="badge bg-secondary">{{ $tag->name }}</span>
            @endforeach
        </p>
    @endif


    <div class="mb-4">
        <a href="/posts" class="btn btn-secondary">Назад до списку</a>

        @if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post->user_id)
            <a href="/posts/{{ $post->id }}/edit" class="btn btn-warning">Редагувати</a>

            <button onclick="deletePost({{ $post->id }})" class="btn btn-danger">Видалити</button>

        @endif
    </div>
    <hr>

    <h3>Коментарі:</h3>
    @foreach($post->comments as $comment)
        <div>
            <strong>{{ $comment->user->name }}</strong>:
            <p>{{ $comment->content }}</p>
        </div>
    @endforeach

    @if(isset($_SESSION['user_id']))
        <form action="/posts/{{ $post->id }}/comments" method="POST">
            <textarea name="content" class="form-control" rows="3" placeholder="Додати коментар"></textarea>
            <button type="submit" class="btn btn-primary mt-2">Коментувати</button>
        </form>
    @else
        <p>Для додавання коментаря потрібно авторизуватись.</p>
    @endif

@endsection

<script>
    function deletePost(postId) {
        if (confirm('Ви впевнені, що хочете видалити цей пост?')) {
            fetch(`/posts/${postId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-HTTP-Method-Override': 'DELETE',
                    'X-Requested-With': 'XMLHttpRequest'
                },
            })
                .then(response => {
                    if (response.ok) {
                        window.location.href = '/posts';
                    } else {
                        response.text().then(text => {
                            console.log(text);
                            alert(`Помилка при видаленні поста: ${text}`);
                        });
                    }
                })
                .catch(error => {
                    alert('Щось пішло не так!');
                });
        }
    }
</script>