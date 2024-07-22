<?php

declare(strict_types=1);

namespace App\Controllers;


use App\Models\Post;
use App\DAOs\PostDAO;
use App\DAOs\UserDAO;
use App\Models\User;

class PostController
{
    static public function create(array $params): ?array
    {

        $serializado = UserDao::buscarUno($params['id_user']);
        $user = User::deserializar($serializado);
        $Post = new Post(
            id: 0,
            titulo: $params['titulo'],
            descripcion: $params['descripcion'],
            picture: $params['picture'],
            created_at: "",
            updated_at: "",
            is_active: 1,
            user: $user

        );
        return PostDAO::crear(serializable: $Post);
    }
    static public function update(array $params): ?array
    {
        $params['user'] = UserDAO::buscarUno($params['id_user']);
        $Post = Post::deserializar($params);
        return PostDAO::modificar(serializable: $Post);
    }
    static public function destroy(int $id): ?array
    {
        return PostDAO::borrar($id);
    }

    static public function read(): ?array
    {
        return PostDAO::listar();
    }
    static public function findOne(string|int $id): false |array
    {
        $post = PostDAO::buscarUno($id);
        if (!$post) {
            return [];
        }
        return $post;
    }
    static public function findPostByUser(int $id)
    {
        return $posts = PostDAO::buscarPorUser($id);
    }
}
