<?php

declare(strict_types=1);

namespace App\helpers;

final class CreateSecurePassword
{
    static public function crear($password): string
    {
        $password_secure = password_hash($password, PASSWORD_BCRYPT);
        return $password_secure;
    }
}
