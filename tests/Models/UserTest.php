<?php

declare(strict_types=1);

namespace test;

require_once __DIR__ . '../../../env.php';

use App\Models\Rol;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use App\Models\User;

final class UserTest extends TestCase
{
    public static function UserProvider(): array
    {

        return [
            [
                new User(
                    id: 0,
                    username: "eguerra",
                    password: "1234",
                    created_at: "now",
                    updated_at: "",
                    is_active: 1,
                    email: "eguerra@gmail.com",
                    rol: new Rol(
                        descripcion: "admin",
                        id: 0,
                        created_at: "now",
                        updated_at: "",
                        is_active: 1
                    )
                )

            ]
        ];
    }
    #[DataProvider('UserProvider')]
    public function testInstanciar(User $user)
    {

        $this->assertEquals("eguerra", $user->getUsername(), "nombre de usuario incorrecto");
        $this->assertEquals("eguerra@gmail.com", $user->getEmail());
        $this->assertInstanceOf(Rol::class, $user->getRol());
    }
    #[DataProvider('UserProvider')]
    public function testSerializar(User $user)
    {
        $Serializado = $user->serializar();
        $this->assertCount(8, $Serializado, "no es la cantidad esperada");
        $this->assertIsArray($Serializado, "no es un array");
        $this->assertEquals("eguerra", $Serializado["username"]);
        $this->assertEquals(0, $Serializado["id"]);
    }
    #[DataProvider('UserProvider')]
    public function testCrearJWT(User $user)
    {
        $jwt = $user->crear_JWT();
        $this->assertNotFalse($jwt);
    }
}
