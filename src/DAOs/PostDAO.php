<?php

declare(strict_types=1);

namespace App\DAOs;

use App\config\DBConect;
use App\Interfaces\ISerializable;


class PostDAO extends DAO
{
    static public function crear(ISerializable $serializable): ?array
    {
        $parametros = $serializable->serializar();

        try {
            $sql = "INSERT into posts (titulo, descripcion,  id_user, likes, dislikes, picture) 
        VALUES (:titulo, :descripcion, :id_user, :likes, :dislikes, :picture)";
            $params = [
                'titulo' => $parametros['titulo'],
                'descripcion' => $parametros['descripcion'],
                'id_user' => $parametros['user']['id'],
                'likes' => $parametros['likes'],
                'dislikes' => $parametros['dislikes'],
                'picture' => $parametros['picture']
            ];
            $resultado = DBConect::write(sql: $sql, params: $params);
            if ($resultado instanceof \PDOException) {
                return ['status' => 403, 'message' => "error al intentar crear post"];
            }
            if ($resultado === 0) {
                return ['status' => 403, 'message' => "error al intentar crear usuario"];
            } else {
                return ['status' => 200, 'message' => "post se creo correctamente"];
            }
        } catch (\PDOException $error) {
            return ['status' => 403, 'message' => $error];
        };
    }
    static public function listar(): ?array
    {
        try {
            $sql = "select * from posts";
            $params = [];
            $post_list = [];
            $posts = DBConect::read(sql: $sql, params: $params);
            if (!$posts) {
                return ['status' => 404, 'message' => 'no se encontraron posts'];
            }
            foreach ($posts as $post) {
                $post['user'] = UserDAO::buscarUno($post['id_user']);
                $post_list[] = $post;
            }

            return $post_list;
        } catch (\PDOException $error) {
            return ['status' => 403, 'message' => $error];
        };
    }
    static public function modificar(ISerializable $serializable): ?array
    {
        $parametros = $serializable->serializar();
        try {
            $sql = "UPDATE posts SET 
        titulo = :titulo,
        descripcion = :descripcion,
        likes = :likes, 
        dislikes = :dislikes, 
        picture =:picture 
        WHERE id=:id";
            $params = [
                'titulo' => $parametros['titulo'],
                'descripcion' => $parametros['descripcion'],
                'id' => $parametros['id'],
                'likes' => $parametros['likes'],
                'dislikes' => $parametros['dislikes'],
                'picture' => $parametros['picture']

            ];
            $resultado =  DBConect::write(sql: $sql, params: $params);
            if ($resultado instanceof \PDOException) {
                return ['status' => 403, 'message' => "error al intentar modificar post"];
            }
            if ($resultado === 0) {
                return ['status' => 403, 'message' => "error al intentar modificar usuario"];
            } else {
                return ['status' => 200, 'message' => "post se modifico correctamente"];
            }
        } catch (\PDOException $error) {
            return ['status' => 403, 'message' => $error];
        };
    }
    static public function borrar(string|int $id): ?array
    {
        try {
            $sql = "DELETE FROM posts WHERE id=:id";
            $params = ['id' => $id];
            $resultado = DBConect::write(sql: $sql, params: $params);
            if ($resultado instanceof \PDOException) {
                return ['status' => 403, 'message' => "error al intentar eliminar un post"];
            }
            if ($resultado === 0) {
                return ['status' => 403, 'message' => "error al intentar eliminar usuario"];
            } else {
                return ['status' => 200, 'message' => "post se creo elimino correctamente"];
            }
        } catch (\PDOException $error) {
            return ['status' => 403, 'message' => $error];
        };
    }
    static public function buscarUno(string|int $id): false|array
    {
        try {
            $sql = "SELECT * FROM posts WHERE id =:id;";
            $param = ['id' => $id];
            $post_find = DBConect::read(sql: $sql, params: $param);
            if (!$post_find) {
                return ['status' => 404, 'message' => 'no se encontro el post'];
            }
            $post_find['user'] = UserDAO::buscarUno($post_find['id_user']);
            unset($post_find['id_user']);
            return $post_find;
        } catch (\PDOException $error) {
            return ['status' => 403, 'message' => $error];
        };
    }

    public static function buscarPorUser(int $id): array
    {
        try {
            $sql = "SELECT * FROM posts WHERE id_user = :id";
            $params = ['id' => $id];
            $posts_list = DBConect::read(sql: $sql, params: $params);

            if (!$posts_list) {
                return ['status' => 404, 'message' => 'no se encontraron posts'];
            }
            return $posts_list;
        } catch (\PDOException $error) {
            return ['status' => 403, 'message' => $error];
        };
    }
}
