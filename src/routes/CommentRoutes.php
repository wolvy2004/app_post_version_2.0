<?php

declare(strict_types=1);

namespace App\routes;

use App\Controllers\CommentController;
use Slim\App;
use App\Interfaces\IRoute;
use App\middlewares\Validate;
use Psr\Http\Message\ServerRequestInterface  as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CommentRoutes implements IRoute
{
    static public function configure(App $app)
    {
        $app->get('/apiv1/comments', function (Request $request, Response $response, array $params) {
            $payload = json_encode(CommentController::read(), JSON_PRETTY_PRINT);
            $response->getBody()->write($payload);
            return $response;
        })->add(new Validate);
        $app->get('/apiv1/comments/{id}', function (Request $request, Response $response, array $args) {

            $payload = json_encode(CommentController::findByPost((int)$args['id']), JSON_PRETTY_PRINT);
            $response->getBody()->write($payload);
            return $response;
        });
        $app->get('/apiv1/comments/user/{id}', function (Request $request, Response $response, array $args) {
            $payload = json_encode(CommentController::findByUser((int)$args['id']), JSON_PRETTY_PRINT);
            $response->getBody()->write($payload);
            return $response;
        })->add(new Validate);
        $app->get('/apiv1/comments/post/{id}', function (Request $request, Response $response, array $args) {
            $payload = json_encode(CommentController::findByPost((int)$args['id']), JSON_PRETTY_PRINT);
            $response->getBody()->write($payload);
            return $response;
        });



        $app->post('/apiv1/comments', function (Request $request, Response $response) {
            $parametros = json_decode(file_get_contents('php://input'), true);
            $payload = json_encode(CommentController::create($parametros), JSON_PRETTY_PRINT);
            $response->withHeader('Content-Type', 'application/json');
            $response->getBody()->write($payload);
            return $response;
        });
        $app->put('/apiv1/comments/{id}', function (Request $request, Response $response) {
            $parametros = json_decode(file_get_contents('php://input'), true);
            $payload = json_encode(CommentController::update($parametros));
            $response->getBody()->write($payload);
            return $response;
        });
        $app->delete('/apiv1/comments/{id}', function (Request $request, Response $response, array $args) {

            $payload = json_encode(CommentController::destroy($args["id"]));
            $response->getBody()->write($payload);
            return $response;
        });
    }
}
