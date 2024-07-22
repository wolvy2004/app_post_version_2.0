<?php

declare(strict_types=1);

namespace App\routes;

use App\Controllers\AuthUserController;
use App\Interfaces\IRoute;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

class AuthUserRoutes implements IRoute
{
    static public function configure(App $app): App
    {
        $app->post('/login', function (Request $request, Response $response, array $arg) {
            $params = json_decode(file_get_contents('php://input'), true);
            $payload = json_encode(AuthUserController::validarAcceso($params['username'], $params['password']), JSON_PRETTY_PRINT);
            $response->getBody()->write($payload);
            return $response; //
        });
        return $app;
    }
}
