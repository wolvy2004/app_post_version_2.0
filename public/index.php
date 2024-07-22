<?php

declare(strict_types=1);
require_once __DIR__ . '../../env.php';



use App\routes\UserRoutes;
use App\routes\RolRoutes;
use App\routes\CommentRoutes;
use App\routes\PostRoutes;
use App\routes\AuthUserRoutes;
use Slim\Factory\AppFactory;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Allow: GET, POST, PUT, DELETE, OPTIONS");


$app = AppFactory::create();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
UserRoutes::configure($app);
//RolRoutes::configure($app);
CommentRoutes::configure($app);
PostRoutes::configure($app);
AuthUserRoutes::configure($app);
$app->run();
