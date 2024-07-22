<?php

declare(strict_types=1);

namespace Raiz\Handlers;

require_once __DIR__ . '../../../vendor/autoload.php';

# -- 😃 nombre de clase -- #
class ErrorHandler extends \Exception
{
    const E_404 = "404 Not Found";
    const E_KEY = "CLAVE NO ENCONTRADA";
    const E_MISS_DATE = "DATOS NO ENCONTRADOS";
}
