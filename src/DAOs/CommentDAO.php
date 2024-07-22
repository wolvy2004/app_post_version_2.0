<?php

namespace App\DAOs;

use App\config\DBConect;
use App\DAOs\DAO;
use App\Interfaces\ISerializable;
use App\Models\Comment;

class CommentDAO extends DAO
{
    static public function crear(ISerializable $serializable): ?array
    {
        $parametros = $serializable->serializar();
        print_r($parametros);
        $sql = "INSERT INTO comments (comentario, id_user, id_post) VALUES (:comentario, :id_user, :id_post)";
        $params = ['comentario' => $parametros['comentario'], 'id_user' => $parametros['user']['id'], 'id_post' => $parametros['post']['id']];
        $result = DBConect::write(sql: $sql, params: $params);
        if ($result) {
            return [];
        } else {
            return [];
        }
    }
    static public function listar(): array
    {
        $sql = "SELECT * FROM comments";
        return DBConect::read(sql: $sql);
    }
    static public function modificar(ISerializable $serializable): ?array
    {
        $parametros = $serializable->serializar();
        $sql = "UPDATE comments SET comentario =:comentario WHERE id =:id";
        $params = [
            "comentario" => $parametros['comentario'],
            "id" => $parametros['id']
        ];
        $result = DBConect::write(sql: $sql, params: $params);
        if ($result) {
            return [];
        } else {
            return [];
        }
    }
    static public function borrar(string|int $id): ?array
    {

        $sql = "DELETE FROM comments WHERE id =:id";
        $params = ['id' => $id];
        $result = DBConect::write(sql: $sql, params: $params);
        if ($result) {
            return [];
        } else {
            return [];
        }
    }
    static public function buscarUno(string|int $id): false|array
    {
        $sql = "SELECT * FROM comments WHERE id = :id";
        $parametros = ['id' => $id];
        return DBConect::read(sql: $sql, params: $parametros);
    }
    static public function buscarPorPost(int $id): array
    {
        $sql = "SELECT * FROM comments WHERE id_post = :id";
        $params = ['id' => $id];
        $comments = DBConect::read(sql: $sql, params: $params);
        $comments_list = [];

        if (count($comments) > 0)
            if (!key_exists('id_user', $comments)) {
                foreach ($comments as $comment) {
                    $comment['user'] = UserDAO::buscarUno($comment['id_user']);
                    $comments_list[] = $comment;
                }
            } else {
                $comments['user'] = UserDAO::buscarUno($comments['id_user']);
                $comments_list[] = $comments;
            }


        return $comments_list;
    }
    static public function buscarPorUser(int $id): array
    {
        $sql = "SELECT * FROM comments WHERE id_user = :id";
        $params = ['id' => $id];
        $comments_list = DBConect::read(sql: $sql, params: $params);
        return $comments_list;
    }
}
