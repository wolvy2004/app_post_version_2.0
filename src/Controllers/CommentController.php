<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\ControllerBase;
use App\DAOs\CommentDAO;
use Serializable;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;

class CommentController extends ControllerBase
{
    static public function create(array $params): ?array
    {
        $user = UserController::findOne($params['id_user']);
        $post = PostController::findOne($params['id_post']);

        $comment = new Comment(
            id: 0,
            comentario: $params['comentario'],
            user: User::deserializar($user),
            post: Post::deserializar($post),
            created_at: "now",
            updated_at: null,
            is_active: 1
        );

        return CommentDAO::crear(serializable: $comment);
    }
    static public function update(array $params): ?array
    {
        $Comment = Comment::deserializar($params);
        return CommentDAO::modificar(serializable: $Comment);
    }
    static public function destroy(int $id): ?array
    {
        return CommentDAO::borrar($id);
    }

    static public function read(): ?array
    {
        return CommentDAO::listar();
    }
    static public function findOne(string|int $id): false|array
    {
        return CommentDAO::buscarUno($id);
    }
    static public function findByUser(int $id): ?array
    {
        return CommentDAO::buscarPorUser(id: $id);
    }
    static public function findByPost(int $id): ?array
    {
        return CommentDAO::buscarPorPost(id: $id);
    }
}
