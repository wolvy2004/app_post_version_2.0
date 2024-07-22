<?php

declare(strict_types=1);

namespace App\DAOs;

use App\config\DBConect;
use App\Models\Rol;
use App\Interfaces\ISerializable;

class RolDAO extends DAO
{
    static public function crear(ISerializable $serializable): ?array
    {
        $parametros = $serializable->serializar();
        $sql = "INSERT INTO roles (descripcion) 
        VALUES (:descripcion)";
        $params = [
            'descripcion' => $parametros['descripcion'],
        ];
        $result = DBConect::write(sql: $sql, params: $params);
        if ($result) {
            return [];
        } else {
            return [];
        }
    }
    static public function listar(): array
    {
        $sql = "select * from roles";
        $params = [];
        return DBConect::read(sql: $sql, params: $params);
    }
    static public function modificar(ISerializable $serializable): ?array
    {
        $parametros = $serializable->serializar();
        $sql = "UPDATE roles SET 
        descripcion = :descripcion 
        WHERE id=:id";
        $params = [
            'descripcion' => $parametros['descripcion'],
            'id' => $parametros['id']

        ];
        $result = DBConect::write(sql: $sql, params: $params);
        if ($result) {
            return [];
        } else {
            return [];
        }
    }
    static public function borrar(int|string $id): ?array
    {
        $sql = "DELETE FROM roles WHERE id=:id";
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
        $sql = "SELECT * FROM roles WHERE id=:id";
        $params = ['id' => $id];
        $result = DBConect::read(sql: $sql, params: $params);
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }
}
