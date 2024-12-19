<?php

namespace Alison\SlimBladeBlog\Controller;

use Alison\SlimBladeBlog\Model\Comment;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class CommentController
{
    public function index(Request $request, Response $response, array $args)
    {
        $comments = Comment::all();

        $commentsArray = $comments->toArray();

        $response->getBody()->write(json_encode($commentsArray));

        return $response->withHeader('Content-Type', 'application/json');
    }

}