<?php

declare(strict_types=1);
require_once __DIR__ . '../../../env.php';

use App\config\DBConect;
use PHPUnit\Framework\TestCase;
use App\Controllers\RolController;


class RolControllerTest extends TestCase
{

    public function testCrearRol()
    {
        $params = ["descripcion" => "super mega admin"];
        $result = RolController::create($params);
        $this->assertEquals($result, 1);
    }

    public function testUpdateRol()
    {
        $params = [
            'descripcion' => 'super extra super admin',
            'id' => $this->lastItem()
        ];
        $result = RolController::update($params);
        $this->assertEquals($result, 1);
    }
    public function testDeleteRol()
    {
        $result = RolController::destroy($this->lastItem());
        $this->assertEquals($result, 1);
    }

    public function lastItem(): int
    {
        $sql = 'SELECT MAX(id) id from Roles';
        $max = DBConect::read($sql);
        return $max['id'];
    }
}
