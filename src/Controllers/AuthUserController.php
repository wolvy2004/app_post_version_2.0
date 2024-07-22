<?php

declare(strict_types=1);

namespace App\Controllers;

use App\helpers\Auth;

/** 🔒🧑👌   
 * Esta clase se encarga de controlar la autenticacion de los usuarios una vez que 
 * estan registrados en la base de datos, verifica que su username y password
 * sean correctos y devuelve un jwt con los datos de acceso a las diferentes
 * areas permitidas por su rol dentro de la aplicacion
 * 
 */

class AuthUserController
{

    public static function validarAcceso(string $username, string $password): array
    {

        return (new Auth)(username: $username, password: $password);
    }
    public static function validarRutas(string $access_jwt, string $rol)
    {
    }
}
