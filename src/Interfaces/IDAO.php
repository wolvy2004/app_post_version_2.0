<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Interfaces\ISerializable;

interface IDAO
{
    static function crear(ISerializable $serializable): int;
    static function listar(): ?array;
    static function modificar(ISerializable $serializable): int;
    static function borrar(string|int $id): int;
    static function buscarUno(string|int $id): false|array;
}
