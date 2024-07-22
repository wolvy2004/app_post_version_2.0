<?php

namespace App\routes;

use App\Interfaces\IRoute;
use Slim\App;
use App\Controllers\UserController;
use Psr\Http\Message\ServerRequestInterface  as Request;
use Psr\Http\Message\ResponseInterface as Response;

abstract class RouteBase implements IRoute
{
}
