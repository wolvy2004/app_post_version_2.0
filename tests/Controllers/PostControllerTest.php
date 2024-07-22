<?php

declare(strict_types=1);
require_once __DIR__ . '../../../env.php';

use App\config\DBConect;
use PHPUnit\Framework\TestCase;
use App\Models\Post;
use App\Models\Rol;
use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Controllers\PostController;

class PostControllerTest extends TestCase
{

    public static function PostProvider(): array
    {

        $rol = new Rol(id: 1, created_at: 'now', updated_at: '', is_active: 1, descripcion: 'super administrator');
        $user = new User(
            id: 1,
            created_at: 'now',
            updated_at: '',
            is_active: 1,
            username: 'eguerra',
            password: '123456',
            email: 'eguerra@example.com',
            rol: $rol
        );

        return [
            [

                new Post(
                    id: 0,
                    created_at: 'now',
                    updated_at: '',
                    is_active: 1,
                    post: 'esto es un post de prueba',
                    likes: 0,
                    dislikes: 0,
                    picture: '',
                    user: $user
                )

            ]
        ];
    }

    #[DataProvider('PostProvider')]
    public function testCrearPost(Post $nuevo_post)
    {

        $NuevoPost = $nuevo_post->serializar();
        $result = PostController::create($NuevoPost);
        $this->assertEquals(1, $result);

        $id = $this->lastItem();

        $find_post = PostController::findOne($id);

        $this->assertEquals($NuevoPost['post'], $find_post['post']);
    }

    #[DataProvider('PostProvider')]
    public function testUpdatePost(Post $post): void
    {

        $post->setPost('esto es un post modificado');
        $id = $this->lastItem();
        $post_a_modificar = $post->serializar();
        $post_a_modificar['id'] = $id;
        $result = PostController::update($post_a_modificar);
        $this->assertEquals(1, $result);
        $find_post = PostController::findOne($id);
        $this->assertEquals($post_a_modificar['post'], $find_post['post']);
    }
    public function testListarPosts(): void
    {
        $listado_post = PostController::read();
        $this->assertIsArray($listado_post);
        $this->assertGreaterThanOrEqual(0, count($listado_post));
    }
    public function testFindPost()
    {
        $id = $this->lastItem();
        $post = PostController::findOne(id: $id);
        $this->assertIsArray($post);
        $this->assertEquals(9, count($post));
    }
    public function testDeletePost()
    {
        $id_post = $this->lastItem();
        $result = PostController::destroy($id_post);
        $this->assertEquals(1, $result);
        $postDelete = PostController::findOne($id_post);
        $this->assertCount(0, $postDelete);
    }

    public function lastItem(): int
    {
        $sql = 'SELECT MAX(id) id from posts';
        $max = DBConect::read($sql);
        return $max['id'];
    }
}
