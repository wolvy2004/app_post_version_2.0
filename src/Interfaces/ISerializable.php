<?php

declare(strict_types=1);

namespace App\Interfaces;


interface ISerializable
{
    /** @return Array */
    public function serializar(): array;
    /** metodo para convertir un array en un objeto */
    /** @return ISerializable */
    static function deserializar(array $serializable): object;
}
