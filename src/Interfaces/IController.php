<?php

declare(strict_types=1);

namespace App\Interfaces;

/** ?arrayerface para los controladores, deben implementar los metodos basicos */
interface IController
{
    /** @var params $params*/
    static function create(array $params): ?array;
    /** @return Array */
    static function read(): ?array;
    /** @return array mixed[] */
    static function destroy(int $id): ?array;
    static function update(array $register): ?array;
    static function findOne(string|int $id): false|array;
}
