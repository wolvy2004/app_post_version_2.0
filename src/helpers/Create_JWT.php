<?php

declare(strict_types=1);

namespace App\helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;

class Create_JWT
{
    static  $secret_key = 'pwd2024';
    static function crear(User $user): string
    {



        $username = $user->getUsername();
        $rol = $user->getRol()->getDescripcion();
        $issuer_claim = "pwd2024"; // this can be the servername
        //$audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim + 10; //not before in seconds
        $expire_claim = $issuedat_claim + 36000; // expire time in seconds
        $token = array(
            "iss" => $issuer_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array(
                "username" => $username,
                "rol" => $rol
            )
        );

        $jwt = JWT::encode(payload: $token, alg: "HS256", key: Self::$secret_key);
        return $jwt;
    }
    static function check(string $jwt)
    {
        $jwt_checked = JWT::decode(jwt: $jwt, keyOrKeyArray: new Key(Self::$secret_key, 'HS256'));
        return $jwt_checked;
    }
}
