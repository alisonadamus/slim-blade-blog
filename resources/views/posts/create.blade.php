@extends('home')

@section('title', 'Створення поста')

@section('content')
    <h1>Створити новий пост</h1>

    @if(isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
    @endif

    <form action="/posts" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Вміст</label>
            <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
        </div>
        <div class="mb-3">
            <label for="tags" class="form-label">Теги</label>
            <select name="tags[]" id="tags" class="form-control" multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Зберегти пост</button>
    </form>
@endsection
