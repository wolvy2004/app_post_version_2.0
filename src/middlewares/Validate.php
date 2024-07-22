<?php

namespace App\middlewares;

use App\helpers\Create_JWT;
use Exception;
use Firebase\JWT\JWT;
use Nyholm\Psr7\Response as Psr7Response;
use Psr\Http\Message\ServerRequestInterface  as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;



class Validate
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = new Psr7Response;

        if ($request->getHeaderLine("Authorization")) {
            $aut = (string)($request->getHeaderLine("Authorization"));

            $jwt = explode(" ", $aut);
            $checked = Create_JWT::check($jwt[1]);
            if (time() > $checked->exp) {
                $respuesta = json_encode(['message' => "Acceso no permido token no valido" . time()], JSON_PRETTY_PRINT);
                $response->getBody()->write($respuesta);
                return $response->withStatus(403);
            }
            return $handler->handle($request);
        } else {
            $respuesta = json_encode(['message' => 'Acceso no permido'], JSON_PRETTY_PRINT);
            $response->getBody()->write($respuesta);
            return $response->withStatus(403);
        }
    }
}
