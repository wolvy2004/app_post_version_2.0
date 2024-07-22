<?php

declare(strict_types=1);
require_once __DIR__ . '../../../env.php';

use App\config\DBConect;
use App\Controllers\UserController;
use App\Handlers\Errors\ErrorDAO;
use App\Models\User;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Models\Rol;

class UserControllerTest extends TestCase
{
    public static function UserProvider(): array
    {

        return [
            [
                new User(
                    id: 0,
                    username: "mguerra",
                    password: "1234",
                    created_at: "now",
                    updated_at: "",
                    is_active: 1,
                    email: "mguerra@gmail.com",
                    rol: new Rol(
                        descripcion: "admin",
                        id: 1,
                        created_at: "now",
                        updated_at: "",
                        is_active: 1
                    )
                )

            ]
        ];
    }
    #[DataProvider('UserProvider')]
    public function testCrearUser(User $user)
    {
        try {
            $usuario_serializado = $user->serializar();
            $result = UserController::create(params: $usuario_serializado);
            $result = UserController::create(params: $usuario_serializado);    # code...
            $this->assertEquals($result, 1, "User not created successfully");    # code...
        } catch (Throwable $e) {
            echo "Test corrido con Error: " . $e->getMessage() . "\n";
        }
    }
    #[DataProvider('UserProvider')]
    public function testModificarUser(User $user)
    {

        $user->setPassword("1254154");
        $user->setEmail('mmguerras@hotmail.com');
        $usuario_serializado = $user->serializar();
        $result = UserController::update(params: $usuario_serializado);
        $usuario_modificado = UserController::findOne(id: $user->getUsername());
        $this->assertEquals($result, 1, "User not updated successfully");
    }
    #[DataProvider('UserProvider')]
    public function testDeleteUser(User $user)
    {
        $usuario_serializado = $user->serializar();
        $result = UserController::destroy(id: $usuario_serializado['username']);
        $this->assertEquals(1, $result, "User not destroyed successfully");
    }
}
