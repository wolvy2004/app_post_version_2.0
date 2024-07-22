<?php

declare(strict_types=1);

namespace App\DAOs;

use App\config\DBConect;
use App\DAOs\DAO;
use App\Handlers\Errors\ErrorDAO;
use App\Interfaces\ISerializable;
use App\Models\Rol;
use PDO;
use PDOException;

class UserDAO extends DAO
{
    static function crear(ISerializable $serilizable): ?array
    {

        $user = $serilizable->serializar();
        $sql = "INSERT INTO users (username, password, email, id_rol, picture_profile)
        values (:username, :password, :email, :id_rol, :picture_profile)";
        if ($user['picture_profile'] === "") {
            $user['picture_profile'] = "picture_default.jpg";
        }
        $parametros = [
            'username' => $user['username'],
            'password' => $user['password'],
            'email' => $user['email'],
            'id_rol' => $user['rol']['id'],
            'picture_profile' => $user['picture_profile']

        ];
        $resultado = DBConect::write(sql: $sql, params: $parametros);

        if ($resultado instanceof PDOException) {
            return [
                'status' => 403,
                'message' => $resultado['message'],
            ];
        }
        if ($resultado === 0) {
            return [
                'status' => 403,
                'message' => "error al intentar crear al usuario" . $user['username']
            ];
        } else {
            return [
                'status' => 201,
                'message' => "usuario " . $user['username'] . " agregado con exito"
            ];
        }
    }
    static function modificar(ISerializable $serilizable): ?array
    {
        $user = $serilizable->serializar();
        $sql = "UPDATE users set 
        password = :password, 
        email=:email ,
        username = :username,
        picture_profile = :picture_profile,
        is_active = :is_active,
        id_rol = :rol
        where id = :id";
        $parametros = [
            'id' => $user['id'],
            "password" =>  $user["password"],
            'username' => $user["username"],
            'email' => $user["email"],
            'picture_profile' => $user["picture_profile"],
            'rol' => $user["rol"]['id'],
            'is_active' => $user["is_active"],
        ];
        $resultado = DBConect::write(sql: $sql, params: $parametros);
        if ($resultado instanceof PDOException) {
            throw new ErrorDAO(cod: ErrorDAO::CREATE_ERROR);
        }
        if ($resultado === 0) {
            return ['status' => 403, 'message' => "error al intentar modificar al usuario" . $user['username']];
        } else {
            return ['status' => 201, 'message' => "usuario" . $user['username'] . " modificado con exito"];
        }
    }
    static function borrar(string|int $id): ?array
    {
        try {
            $sql = "DELETE FROM users WHERE id = :id";
            $parametros = [':id' => $id];
            $resultado = DBConect::write(sql: $sql, params: $parametros);
            if ($resultado instanceof PDOException) {
                return ['status' => 403, 'message' => "error al intentar elimiar usuario"];
            }
            if ($resultado === 0) {
                return ['status' => 403, 'message' => "error al intentar elimiar usuario"];
            } else {
                return ['status' => 200, 'message' => "usuario eliminado con exito"];
            }
        } catch (PDOException $error) {
            return ['status' => 403, 'message' => $error];
        }
    }
    static function listar(): ?array
    {
        $sql = "SELECT * FROM users ";
        $userslist = [];
        $users = DBConect::read(sql: $sql);
        if (key_exists('error', $users)) {
            return [$users['error']];
        }
        foreach ($users as $user) {
            $rol_id = $user['id_rol'];
            $user["rol"] = RolDAO::buscarUno($rol_id);
            $userslist[] = $user;
        }
        return $userslist;
    }
    static function buscarUno(string|int $id): false|array
    {

        if (is_numeric($id)) {
            $sql = "SELECT * FROM users where id=:id";
            $param = ['id' => (int)$id];
            $user_find = DBConect::read(sql: $sql, params: $param);
        } else {
            $sql = "SELECT * FROM users where username=:id";
            $param = ['id' => $id];
            $user_find = DBConect::read(sql: $sql, params: $param);
        }

        if (count($user_find) === 0) {
            return false;
        }
        $user_find['rol'] = RolDAO::buscarUno($user_find['id_rol']);
        unset($user_find['id_rol']);
        return $user_find;
    }

    static function checkEmail($email): bool
    {
        $existe = true;
        $sql = "SELECT * from Users where email = :email";
        $params = ['email' =>  "$email"];
        $response = DBConect::read(sql: $sql, params: $params);
        if (!$response) {
            return $existe = false;
        }
        return $existe;
    }
    static function checkUsername($username): bool
    {
        $existe = true;
        $sql = "SELECT * from Users where username = :username";
        $params = ['username' => "$username"];
        $response = DBConect::read(sql: $sql, params: $params);
        if (!$response) {
            return $existe = false;
        }
        return $existe;
    }
}
