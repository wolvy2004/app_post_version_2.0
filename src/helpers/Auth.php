<?php

declare(strict_types=1);

namespace App\helpers;

use App\Controllers\UserController;
use App\DAOs\UserDAO;
use App\Models\User;

class Auth
{
    public  function __invoke(string $username, string $password): array
    {
        $user_find =  UserController::findOne($username);

        if ($user_find) {
            if (password_verify($password, $user_find["password"])) {
                $user = User::deserializar($user_find);
                $jwt = $user->crear_JWT();
                return [
                    'code' => 200,
                    'access_token' => $jwt,
                    'username' => $user->getUsername(),
                    'rol' =>  $user->getRol()->serializar(),
                    'picture_profile' => $user->getPicture(),
                    'id' => $user->getId(),
                    'authenticated' => true

                ];
            } else {
                return [
                    "message" => "acceso no permitido",
                    "code" => 403
                ];
            }
        } else {
            return [
                "message" => "acceso no permitido",
                "code" => 404
            ];
        }
    }
}
