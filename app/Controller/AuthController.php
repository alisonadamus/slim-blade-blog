<?php

namespace Alison\SlimBladeBlog\Controller;

use Alison\SlimBladeBlog\Model\User;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AuthController
{
    public function showLogin(Request $request, Response $response)
    {
        return view($response, 'auth.login');
    }

    public function showRegister(Request $request, Response $response)
    {
        return view($response, 'auth.register');
    }

    public function register(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $hashedPassword,
        ]);

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;

        return view($response, 'auth.login');
    }

    public function login(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $user = User::where('email', $data['email'])->first();

        if ($user && password_verify($data['password'], $user->password)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            return $response->withHeader('Location', '/posts')->withStatus(302);
        }

        return view($response, 'auth.login', ['error' => 'Невірні дані для входу']);

    }

    public function logout(Request $request, Response $response)
    {
        session_destroy();
        return view($response, 'home');
    }


    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

}