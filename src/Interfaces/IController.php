<?php

declare(strict_types=1);

namespace App\Interfaces;

/** Interface para los controladores, deben implementar los metodos basicos */
interface IController
{
    /** @var params $params*/
    static function create(array $params): int;
    /** @return Array */
    static function read(): ?array;
    /** @return array mixed[] */
    static function destroy(int $id): int;
    static function update(array $register): int;
    static function findOne(string|int $id): ?array;
}
