<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\ModelBase as Model;
use App\Models\User;
use App\Models\Post;
# -- 🛸 nombre de clase -- #
class Comment extends Model
{
    public function __construct(
        private string $comentario,
        private User $user,
        private Post $post,
        int $id,
        string $created_at,
        string | null $updated_at,
        int $is_active,
    ) {
        parent::__construct(
            id: $id,
            created_at: $created_at,
            updated_at: $updated_at,
            is_active: $is_active
        );
        $this->user = $user;
        $this->post = $post;
        $this->comentario = $comentario;
    }

    public function getUser(): User
    {
        return $this->user;
    }
    public function getPost(): Post
    {
        return $this->post;
    }
    public function getComentario(): string
    {
        return $this->comentario;
    }
    public function setComentario(string $comentario): void
    {
        $this->comentario = $comentario;
    }

    public function serializar(): array
    {
        $serializado = array_merge(get_object_vars($this), parent::serializar());
        $serializado['user'] = $serializado['user']->serializar();
        $serializado['post'] = $serializado['post']->serializar();
        return $serializado;
    }
    static public function deserializar(array $parametros): self
    {
        return new self(
            id: $parametros['id'],
            created_at: $parametros['created_at'],
            updated_at: $parametros['updated_at'] ?? "",
            is_active: $parametros['is_active'],
            user: User::deserializar($parametros['user']),
            post: Post::deserializar($parametros['post']),
            comentario: $parametros['comentario']
        );
    }
}
