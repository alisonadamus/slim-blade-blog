<?php


use Alison\SlimBladeBlog\Controller\AuthController;
use Alison\SlimBladeBlog\Controller\CommentController;
use Alison\SlimBladeBlog\Controller\PostController;
use Alison\SlimBladeBlog\Controller\TagController;
use Jenssegers\Blade\Blade;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {

    function view(Response $response, $template, $data = [])
    {
        $views = __DIR__ . '/../resources/views';
        $cache = __DIR__ . '/../storage/cache';
        $blade = (new Blade($views, $cache))->make($template, $data);
        $response->getBody()->write($blade->render());
        return $response;
    }

    $app->get('/', function (Request $request, Response $response) {
        return view($response, 'home');
    });

    $app->get('/login', AuthController::class . ':showLogin');
    $app->post('/login', AuthController::class . ':login');
    $app->get('/register', AuthController::class . ':showRegister');
    $app->post('/register', AuthController::class . ':register');
    $app->get('/logout', AuthController::class . ':logout');

    $app->get('/posts', [PostController::class, 'index']);
    $app->get('/posts/create', [PostController::class, 'create']);
    $app->get('/posts/{id}', [PostController::class, 'show']);
    $app->post('/posts', [PostController::class, 'store']);
    $app->get('/posts/{id}/edit', [PostController::class, 'edit']);
    $app->put('/posts/{id}', [PostController::class, 'update']);
    $app->delete('/posts/{id}', [PostController::class, 'destroy']);
    $app->post('/posts/{id}/comments', [PostController::class, 'addComment']);

    $app->get('/comments', CommentController::class . ':index');

    $app->get('/tags', TagController::class . ':index');
};