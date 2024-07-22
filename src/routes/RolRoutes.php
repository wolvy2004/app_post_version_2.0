<?php

declare(strict_types=1);

namespace App\routes;

use App\Interfaces\IRoute;
use Slim\App;
use App\Controllers\RolController;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class RolRoutes implements IRoute
{
    static public function configure(App $app)
    {
        $app->get('/apiv1/roles', function (Request $request, Response $response, array $params) {
            $payload = json_encode(RolController::read(), JSON_PRETTY_PRINT);
            $response->getBody()->write($payload);
            return $response;
        });
        $app->get('/apiv1/roles/{id}', function (Request $request, Response $response, array $args) {

            $payload = json_encode(RolController::findOne($args['id']), JSON_PRETTY_PRINT);
            $response->getBody()->write($payload);
            return $response;
        });
        $app->post('/apiv1/roles', function (Request $request, Response $response) {
            $parametros = json_decode(file_get_contents('php://input'), true);

            $payload = json_encode(RolController::create($parametros), JSON_PRETTY_PRINT);
            $response->withHeader('Content-Type', 'application/json');
            $response->getBody()->write($payload);
            return $response;
        });
        $app->put('/apiv1/roles/{id}', function (Request $request, Response $response) {
            $parametros = json_decode(file_get_contents('php://input'), true);
            $payload = json_encode(RolController::update($parametros));
            $response->getBody()->write($payload);
            return $response;
        });
        $app->delete('/apiv1/roles/{id}', function (Request $request, Response $response, array $args) {

            $payload = json_encode(RolController::destroy((int)$args["id"]));
            $response->getBody()->write($payload);
            return $response;
        });
    }
}
