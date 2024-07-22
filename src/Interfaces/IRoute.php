<?php

declare(strict_types=1);

namespace App\Interfaces;

use Slim\App;

interface IRoute
{
    static public function configure(App $app);
}
