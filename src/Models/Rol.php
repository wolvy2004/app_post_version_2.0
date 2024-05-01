<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\ModelBase as Model;


class Rol extends Model
{
    public function __construct(
        ?int $id,
        string $created_at,
        string $updated_at,
        public string $descripcion,
        int $is_active = 1
    ) {
        $this->descripcion = $descripcion;
        parent::__construct(
            id: $id,
            is_active: $is_active,
            updated_at: $updated_at,
            created_at: $created_at
        );
    }

    public function serializar(): array
    {
        return array_merge(parent::serializar(), get_object_vars($this));
    }
    static function deserializar(array $serializable): Self
    {
        return new Self(
            id: $serializable['id'] ?? 0,
            descripcion: $serializable['descripcion'],
            created_at: $serializable['created_at'] ?? 'now',
            updated_at: $serializable['updated_at'] ?? " ",
            is_active: $serializable['is_active'] ?? 1,
        );
    }

    public function setDescripcion(string $new_descripcion): void
    {
        $this->descripcion = $new_descripcion;
    }
}
