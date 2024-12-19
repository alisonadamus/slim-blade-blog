<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Головна сторінка</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <header class="my-4">
        <h1>Slim Blade Blog</h1>
        <div class="mb-4">
            @if(isset($_SESSION['user_id']))
                <p>Привіт, {{ $_SESSION['user_name'] }}!</p>
                <a href="/logout" class="btn btn-danger">Вийти</a>
            @else
                <a href="/login" class="btn btn-success">Увійти</a>
                <a href="/register" class="btn btn-primary">Зареєструватися</a>
            @endif
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>