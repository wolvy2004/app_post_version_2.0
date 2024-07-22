<?php

namespace App\Controllers;

use App\DAOs\DAO;
use App\Models\Rol;
use App\DAOs\RolDAO;

class RolController extends ControllerBase
{
    static public function create(array $params): ?array
    {
        $Rol = new Rol(descripcion: $params['descripcion'], id: 0, created_at: 'now', updated_at: "", is_active: 1);
        return RolDAO::crear(serializable: $Rol);
    }
    static public function update(array $params): ?array
    {
        $rol = Rol::deserializar($params);
        return RolDAO::modificar($rol);
    }
    static public function destroy(int $id): ?array
    {
        return RolDAO::borrar($id);
    }

    static public function read(): ?array
    {
        return RolDAO::listar();
    }
    static public function findOne(string|int $id): false |array
    {
        return RolDAO::buscarUno($id);
    }
}
