<?php

declare(strict_types=1);

namespace App\helpers;

use Firebase\JWT\JWT;
use App\Models\User;

class Create_JWT
{
    static function crear(User $user): string
    {
        $username = $user->getUsername();
        $secret_key = "pWd20.24";
        $issuer_claim = "pwd2024"; // this can be the servername
        //$audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim + 10; //not before in seconds
        $expire_claim = $issuedat_claim + 36000; // expire time in seconds
        $token = array(
            "iss" => $issuer_claim,
            //  "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array(
                "username" => $username,
                //"password" => $password
            )
        );



        $jwt = JWT::encode(payload: $token, alg: "HS256", key: $secret_key);
        return json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt,
                "usename" => $username,
                "expireAt" => $expire_claim
            )
        );
    }
}
