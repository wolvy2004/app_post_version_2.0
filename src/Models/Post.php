<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\ModelBase as Model;

class Post extends Model
{
    public function __construct(
        ?int $id,
        string $created_at,
        ?string $updated_at,
        int $is_active,
        private User $user,
        private string $titulo,
        private string $descripcion,
        private ?string $picture,
        private int $likes = 0,
        private int $dislikes = 0

    ) {
        parent::__construct(
            id: $id,
            created_at: $created_at,
            updated_at: $updated_at,
            is_active: $is_active
        );
        $this->user = $user;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->picture = $picture;
        $this->likes = $likes;
        $this->dislikes = $dislikes;
    }

    public function serializar(): array
    {
        $serializado = array_merge(get_object_vars($this), parent::serializar());
        $serializado['user'] = $serializado['user']->serializar();
        return $serializado;
    }
    static public function deserializar(array $deserializar): self
    {

        return new self(
            id: (int)$deserializar['id'],
            created_at: $deserializar['created_at'],
            updated_at: $deserializar['updated_at'],
            is_active: (int)$deserializar["is_active"],
            user: User::deserializar($deserializar["user"]),
            titulo: $deserializar["titulo"],
            descripcion: $deserializar["descripcion"],
            picture: $deserializar["picture"],
            likes: (int)$deserializar["likes"],
            dislikes: (int)$deserializar["dislikes"]
        );
    }
    public function getTitulo(): string
    {
        return $this->titulo;
    }
    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }
    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }
    public function getLikes(): int
    {
        return $this->likes;
    }
    public function setLikes(int $likes): void
    {
        $this->likes += $likes;
    }
    public function getDislikes(): int
    {
        return $this->dislikes;
    }
    public function setDislikes(int $dislikes): void
    {
        $this->dislikes += $dislikes;
    }
    public function getPicture(): string
    {
        return $this->picture;
    }
    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
    }
    public function getUser(): User
    {
        return $this->user;
    }
}
