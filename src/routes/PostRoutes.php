<?php

declare(strict_types=1);

namespace App\routes;

use App\Controllers\CommentController;
use App\Controllers\PostController;
use Slim\App;
use App\Interfaces\IRoute;
use App\middlewares\Validate;
use Psr\Http\Message\ServerRequestInterface  as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\helpers\Upload;


class PostRoutes implements IRoute
{
    static public function configure(App $app)
    {
        $app->get('/apiv1/posts', function (Request $request, Response $response, array $params) {
            $payload = json_encode(PostController::read(), JSON_PRETTY_PRINT);
            $response->getBody()->write($payload);
            return $response;
        });


        $app->get('/apiv1/posts/{id}', function (Request $request, Response $response, array $args) {
            $payload = json_encode(PostController::findOne($args['id']), JSON_PRETTY_PRINT);
            $response->getBody()->write($payload);
            return $response;
        });
        $app->get('/apiv1/posts/{id}/comments', function (Request $request, Response $response, array $args) {
            $payload = json_encode(CommentController::findOne($args['id']), JSON_PRETTY_PRINT);
            $response->getBody()->write($payload);
            return $response;
        });
        $app->get('/apiv1/posts/user/{id}', function (Request $request, Response $response, array $args) {
            $payload = json_encode(PostController::findPostByUser((int)$args['id']), JSON_PRETTY_PRINT);
            $response->getBody()->write($payload);
            return $response;
        });
        $app->post('/apiv1/posts', function (Request $request, Response $response) {
            $params = $request->getParsedBody();
            $upload = $request->getUploadedFiles();
            $file = $upload['file'];
            $directory = $params['directory'];
            if ($file) {
                $file_upload = Upload::save($request, $directory);
                $params['picture'] = $file_upload;
                $payload = json_encode(PostController::create($params), JSON_PRETTY_PRINT);
                $response->getBody()->write($payload);
            } else {
                $payload = json_encode(PostController::create($params), JSON_PRETTY_PRINT);
                $response->getBody()->write($payload);
            }

            return $response;
        })->add(new Validate());
        // modificar PUT
        $app->post('/apiv1/posts/{id}', function (Request $request, Response $response) {
            $params = $request->getParsedBody();
            $upload = $request->getUploadedFiles();

            $directory = $params['directory'];
            if (key_exists("file", $upload)) {
                $file_upload = Upload::save($request, $directory);
                $params['picture'] = $file_upload;
                $payload = json_encode(PostController::update($params), JSON_PRETTY_PRINT);
                $response->getBody()->write($payload);
            } else {
                $payload = json_encode(PostController::update($params), JSON_PRETTY_PRINT);
                $response->getBody()->write($payload);
            }

            return $response;
        })->add(new Validate());
        $app->delete('/apiv1/posts/{id}', function (Request $request, Response $response, array $args) {
            $payload = json_encode(PostController::destroy((int)$args["id"]));
            $response->getBody()->write($payload);
            return $response;
        })->add(new Validate());
    }
}
