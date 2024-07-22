<?php

declare(strict_types=1);

namespace App\routes;

use App\Controllers\UserController;
use App\helpers\Upload;
use App\middlewares\Validate;
use Nyholm\Psr7\ServerRequest as Request;
use Nyholm\Psr7\Response;

use Slim\App;

class UserRoutes
{
    static function configure(App $app)
    {
        $app->get("/apiv1/users", function (Request $request, Response $response) {
            $payload = json_encode(UserController::read());
            $response->getBody()->write($payload);
            return $response;
        })->add(new Validate());

        $app->get("/apiv1/users/{id}", function (Request $request, Response $response, array $arg) {
            $payload = json_encode(UserController::findOne($arg['id']), JSON_PRETTY_PRINT);
            $response->getBody()->write($payload);
            return $response;
        })->add(new Validate());

        $app->delete("/apiv1/users/{id}", function (Request $request, Response $response, array $arg) {
            $payload = json_encode(UserController::destroy($arg['id']), JSON_PRETTY_PRINT);
            $response->getBody()->write($payload);
            return $response;
        })->add(new Validate());

        $app->post("/apiv1/users/create/", function (Request $request, Response $response, array $arg) {

            $params = $request->getParsedBody();
            $directory = $params['directory'];
            if ($params) {
                $files = Upload::save($request, $directory);
                $params['picture_profile'] = $files;
                $payload = json_encode(UserController::create(params: $params));
                $response->getBody()->write($payload);
                return $response;
            }
            return $response;
        });

        $app->post("/apiv1/users/{id}", function (Request $request, Response $response, $arg) {

            $params = $request->getParsedBody();
            $directory = $params['directory'];
            $files = Upload::save($request, $directory);
            $params['picture_profile'] = $files;
            $payload = json_encode(UserController::update(params: $params));
            $response->getBody()->write($payload);
            return $response;
        });

        $app->post('/apiv1/check-email', function (Request $request, Response $response, $arg) {
            $params = json_decode(file_get_contents('php://input'), true);

            $email = $params['email'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response->getBody()->write('email no valido');
                $response->withStatus(400);
                return $response;
            }
            $payload = json_encode(UserController::checkEmail($email));
            $response->getBody()->write($payload);
            return $response;
        });

        $app->get('/apiv1/check-username/{username}', function (Request $request, Response $response, $arg) {
            $payload = json_encode(UserController::checkUsername(username: $arg['username']));
            $response->getBody()->write($payload);
            return $response;
        });
    }
}
