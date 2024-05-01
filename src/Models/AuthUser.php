<?php

declare(strict_types=1);

namespace App\Models;

use App\DAOs\UserDAO;

class AuthUser
{


    public static function validarAcceso(string $username, string $password): array
    {
        $user_find = UserDAO::buscarUno($username);
        if ($user_find != null) {
            if (password_verify($password, $user_find["password"])) {
                $user = User::deserializar($user_find);
                $jwt = $user->crear_JWT();
                return [
                    "message" => "acceso correcto",
                    "code" => 201, "jwt" => $jwt
                ];
            } else {
                return [
                    "message" => "acceso no permitido",
                    "code" => 403
                ];
            }
        } else {
            return ["message" => "usuario no encontrado"];
        }
    }
}
