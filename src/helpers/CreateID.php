<?php

declare(strict_types=1);

namespace App\helpers;

require_once __DIR__ . '../../../env.php';

use Ramsey\Uuid\Uuid;



class CreateID
{
    static function createID()
    {
        $uuid = Uuid::uuid7();

        printf(
            "UUID: %s\nVersion: %d\n",
            $uuid->toString(),
            $uuid->getFields()->getVersion()
        );
    }
}

CreateID::createID();
