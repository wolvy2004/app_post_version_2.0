<?php

declare(strict_types=1);
require_once __DIR__ . '../../../env.php';

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Depends;
use App\Models\User;
use App\Models\Post;
use App\Models\Rol;
use PHPUnit\Framework\Attributes\TestDox;

final class PostTest extends TestCase
{
    public static function PostProvider(): array
    {

        return [
            [
                new Post(
                    id: 0,
                    created_at: 'now()',
                    updated_at: '',
                    is_active: 1,
                    likes: 0,
                    dislikes: 0,
                    post: 'esto es un texto de prueba',
                    picture: 'test.jpg',
                    user: new User(
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

                ),


            ]
        ];
    }
    #[DataProvider('PostProvider')]
    public function testPostAttributes(Post $post)
    {
        $post_message = $post->getPost();
        $user = $post->getUser();
        $texto_de_prueba = "esto es un texto de prueba";
        $this->assertEquals($texto_de_prueba, $post_message);
        $this->assertIsObject($user);
    }
    #[DataProvider('PostProvider')]
    public function testSerializar(Post $post)
    {
        $postSerializado = $post->serializar();
        $this->assertIsArray($postSerializado);
        $this->assertEquals($postSerializado['post'], "esto es un texto de prueba");
        $this->assertEquals($postSerializado['user']["username"], "eguerra");
        return $postSerializado;
    }

    #[DataProvider('PostProvider')]

    public function testDeserializar(Post $post)
    {
        $post_serializado = $post->serializar();
        $postDeserializado = Post::deserializar(deserializar: $post_serializado);
        $this->assertInstanceOf(Post::class, $postDeserializado);
    }
}
