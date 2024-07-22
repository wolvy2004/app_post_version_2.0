<?php

declare(strict_types=1);

namespace App\Controllers;


use App\Controllers\ControllerBase;
use App\DAOs\UserDao;
use App\Models\User;
use App\Models\Rol;

class UserController extends ControllerBase
{

    static function create(array $params): ?array
    {
        $id_rol = $params['rol'] ?? 1;
        $rol = Rol::deserializar(RolController::findOne($id_rol));
        $user = new User(
            picture_profile: $params['picture_profile'],
            id: 0,
            username: $params['username'],
            email: $params['email'],
            password: $params['password'],
            rol: $rol,
            created_at: 'now',
            updated_at: '',
            is_active: 1,

        );

        /**
         * luego ese nuevo objeto user se lo paso como 
         * parametro al metodo de UserDAO::crear() para poder crear un nuevo registro
         * en la tabla users este retorna como resultado 
         * retorno 1 si tuvimos exito 👍 o 0 👎 sino.
         **/
        return UserDao::crear(serilizable: $user);
    }

    static function update(array $params): ?array
    {
        /**
         * los datos planos nuevamente los convierto en un 
         * objeto esto me asegura que la contraseña
         * sea nuevamente encriptada
         * nuevamente utilizo el metodo UserDAO::modificar() para updatear un registro
         * retorno 1 si tuvimos exito 👍 o 0 👎  sino.  
         */
        $params['rol'] = RolController::findOne($params['rol']);
        $user = User::deserializar(serializable: $params);
        return UserDao::modificar(serilizable: $user);
    }
    static function read(): ?array
    {
        /**
         * Usamos el metodo UserDAO:listar() para buscar todos los registros
         * retorno un array con los registros o null en caso de que no
         * exista 😇 .  
         */
        $users = UserDao::listar();

        return $users;
    }
    static function destroy(string|int $id): ?array
    {
        /**
         * Utilizo el metodo UserDAO::borrar() para eliminar un registro
         * para este caso solo utilizo el username del usuario (es una clave unica)
         * retorno 1 si tuvimos exito 👍 o 0 👎  sino.  
         */
        return $result = UserDao::borrar($id);
    }

    static function findOne(string|int $id): false|array
    {
        /**
         * Utilizo el metodo UserDAO::buscarUno() para buscar un registro
         * para este caso solo utilizo el username del usuario (es una clave unica)
         * retorno un array con el registro o null en caso de que no
         * exista. 🐨 
         */

        return UserDao::buscarUno($id);
    }
    static function checkEmail(string $email): bool
    {
        return UserDAO::checkEmail($email);
    }
    static function checkUsername(string $username): bool
    {
        return UserDAO::checkUsername($username);
    }
}
