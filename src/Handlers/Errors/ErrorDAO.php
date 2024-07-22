<?php

declare(strict_types=1);

namespace App\Handlers\Errors;

use App\Models\ModelBase;
use Error;
use PDOException;

class ErrorDAO extends PDOException
{
    const CREATE_ERROR = 403;
    const READ_ERROR = 404;
    const UPDATE_ERROR = 405;
    const DELETE_ERROR = 406;


    public function __construct(int $cod)
    {
        switch ($cod) {
            case self::CREATE_ERROR:
                parent::__construct(
                    message: "error al crear un nuevo REGISTRO \n",
                    code: $cod
                );
                break;
            case self::UPDATE_ERROR:
                parent::__construct(
                    message: "error al modificar un nuevo REGISTRO \n",
                    code: $cod
                );
                break;
            case self::READ_ERROR:
                parent::__construct(
                    message: "error al buscar el/los REGISTRO/s seleccionado/s \n",
                    code: $cod
                );
                break;
            case self::DELETE_ERROR:
                parent::__construct(
                    message: "error al Eliminar un REGISTRO \n",
                    code: $cod
                );
                break;
            default:
                parent::__construct(
                    message: "error codigo no encontrado",
                    code: $cod
                );
        }
    }
}
