@extends('home')

@section('title', 'Редагування поста')

@section('content')
    <h1>Редагувати пост</h1>

    @if(isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
    @endif

    <form action="/posts/{{ $post->id }}" method="POST">

        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Вміст</label>
            <textarea name="content" id="content" class="form-control" rows="5" required>{{ $post->content }}</textarea>
        </div>
        <div class="mb-3">
            <label for="tags" class="form-label">Теги</label>
            <select name="tags[]" id="tags" class="form-control" multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}"
                            @if($post->tags->contains($tag->id)) selected @endif>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="button" onclick="updatePost({{ $post->id }})" class="btn btn-primary">Оновити пост</button>
    </form>
@endsection

<script>
    function updatePost(postId) {
        const title = document.getElementById('title').value;
        const content = document.getElementById('content').value;
        const tags = Array.from(document.getElementById('tags').selectedOptions).map(option => option.value);

        if (!title || !content) {
            alert('Всі поля повинні бути заповнені.');
            return;
        }

        const data = {
            title: title,
            content: content,
            tags: tags
        };

        fetch(`/posts/${postId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data),
        })
            .then(response => {
                if (response.ok) {
                    window.location.href = `/posts/${postId}`;
                } else {
                    alert('Помилка при оновленні поста.');
                }
            })
            .catch(error => {
                alert('Щось пішло не так!');
            });
    }
</script>