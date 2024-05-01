<?php

declare(strict_types=1);
require_once __DIR__ . '../../../env.php';

use App\config\DBConect;
use PHPUnit\Framework\TestCase;
use App\Controllers\CommentController;
use App\DAOs\CommentDAO;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Models\Comment;
use App\Models\Rol;
use App\Models\User;
use App\Models\Post;

class CommentControllerTest extends TestCase
{
    public static function CommentProvider(): array
    {

        $user = new User(
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
        );
        $post =  new Post(
            id: 0,
            created_at: 'now()',
            updated_at: '',
            is_active: 1,
            likes: 0,
            dislikes: 0,
            post: 'esto es un texto de prueba',
            picture: 'test.jpg',
            user: $user
        );
        return [
            [new Comment(
                user: $user,
                post: $post,
                id: 0,
                created_at: 'now()',
                updated_at: '',
                is_active: 1,
                comentario: "es un comentario de prueba"
            )]
        ];
    }
    #[DataProvider('CommentProvider')]
    public function testCrearComment(Comment $comment)
    {
        $comentario = $comment->getComentario();
        $comment_esperado =  "es un comentario de prueba";
        $this->assertStringContainsString($comment_esperado, $comentario);
        $this->assertInstanceOf(User::class, $comment->getUser());
        $this->assertInstanceOf(Post::class, $comment->getPost());
    }

    public function testReadComment()
    {
        $listaComments = CommentDAO::listar();
        $this->assertIsArray($listaComments);
        $this->assertGreaterThan(0, count($listaComments));
    }
    #[DataProvider('CommentProvider')]
    public function testUpdateComment(Comment $comment)
    {
        $id = $this->lastItem();
        $comment->setComentario("comentario modificado");
        $comment_serializado = $comment->serializar();
        $comment_serializado['id'] = $id;
        $result = CommentController::update($comment_serializado);
        $this->assertEquals(1, $result);
    }
    public function testDeleteComment()
    {
        $id = $this->lastItem();
        $comment_serializado['id'] = $id;
        $result = CommentController::destroy($id);
        $this->assertEquals(1, $result);
    }
    public function testFindComment()
    {
        $id = $this->lastItem();
        $comment_serializado['id'] = $id;
        $findComment = CommentController::findOne($id);
        $this->assertIsArray($findComment);
    }
    public function lastItem(): int
    {
        $sql = 'SELECT MAX(id) id from comments';
        $max = DBConect::read($sql);
        return $max[0]['id'];
    }
}
