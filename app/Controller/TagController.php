<?php

namespace Alison\SlimBladeBlog\Controller;

use Alison\SlimBladeBlog\Model\Tag;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class TagController
{
    public function index(Request $request, Response $response, array $args)
    {
        $tags = Tag::all();
        $tagsArray = $tags->toArray();

        $response->getBody()->write(json_encode($tagsArray));

        return $response->withHeader('Content-Type', 'application/json');
    }

}