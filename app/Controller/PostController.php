<?php

namespace Alison\SlimBladeBlog\Controller;

use Alison\SlimBladeBlog\Model\Comment;
use Alison\SlimBladeBlog\Model\Post;
use Alison\SlimBladeBlog\Model\Tag;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PostController
{

    public function index(Request $request, Response $response)
    {
        $posts = Post::with('tags', 'user')->latest()->get();
        return view($response, 'posts.index', compact('posts'));
    }


    public function show(Request $request, Response $response, array $args)
    {
        $post = Post::with(['user', 'tags', 'comments.user'])->find($args['id']);
        if (!$post) {
            $response->getBody()->write('Пост не знайдено.');
            return $response->withStatus(404);
        }

        return view($response, 'posts.show', compact('post'));
    }


    public function create(Request $request, Response $response)
    {
        if (!isset($_SESSION['user_id'])) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $tags = Tag::all();
        return view($response, 'posts.create', compact('tags'));
    }

    public function store(Request $request, Response $response)
    {
        if (!isset($_SESSION['user_id'])) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $data = $request->getParsedBody();

        if (empty($data['title']) || empty($data['content'])) {
            return view($response, 'posts.create', [
                'error' => 'Заголовок та вміст не можуть бути порожніми.',
                'tags' => Tag::all(),
            ]);
        }

        $post = Post::create([
            'user_id' => $_SESSION['user_id'],
            'title' => $data['title'],
            'content' => $data['content'],
        ]);

        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $response->withHeader('Location', '/posts/' . $post->id)->withStatus(302);
    }

    public function edit(Request $request, Response $response, array $args)
    {
        if (!isset($_SESSION['user_id'])) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $post = Post::find($args['id']);
        if (!$post || $post->user_id !== $_SESSION['user_id']) {
            $response->getBody()->write('Доступ заборонено.');
            return $response->withStatus(403);
        }

        $tags = Tag::all();
        return view($response, 'posts.edit', compact('post', 'tags'));
    }

    public function update(Request $request, Response $response, array $args)
    {
        if (!isset($_SESSION['user_id'])) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $post = Post::find($args['id']);
        if (!$post || $post->user_id !== $_SESSION['user_id']) {
            $response->getBody()->write('Доступ заборонено.');
            return $response->withStatus(403);
        }

        $data = json_decode($request->getBody(), true);

        if (empty($data['title']) || empty($data['content'])) {
            return view($response, 'posts.edit', [
                'post' => $post,
                'tags' => Tag::all(),
                'error' => 'Заголовок та вміст не можуть бути порожніми.',
            ]);
        }

        $post->update([
            'title' => $data['title'],
            'content' => $data['content'],

        ]);

        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $response->withHeader('Location', '/posts/' . $post->id)->withStatus(200);
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        if (!isset($_SESSION['user_id'])) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $post = Post::find($args['id']);
        if (!$post || $post->user_id !== $_SESSION['user_id']) {
            $response->getBody()->write('Доступ заборонено.');
            return $response->withStatus(403);
        }

        $post->delete();

        return $response->withHeader('Location', '/posts')->withStatus(200);
    }

    public function addComment(Request $request, Response $response, array $args)
    {
        if (!isset($_SESSION['user_id'])) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $data = $request->getParsedBody();

        $post = Post::find($args['id']);
        if (!$post) {
            $response->getBody()->write('Пост не знайдено.');
            return $response->withStatus(404);
        }

        if (empty($data['content'])) {
            return $response->withHeader('Location', '/posts/' . $post->id)
                ->withStatus(302)
                ->withHeader('X-Error', 'Коментар не може бути порожнім');
        }

        Comment::create([
            'post_id' => $post->id,
            'user_id' => $_SESSION['user_id'],
            'content' => $data['content'],
        ]);

        return $response->withHeader('Location', '/posts/' . $post->id)->withStatus(302);
    }
}