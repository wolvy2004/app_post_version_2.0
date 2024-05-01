<?php

declare(strict_types=1);
require_once __DIR__ . '../../../env.php';

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Depends;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use App\Models\Rol;

class CommentTest extends TestCase
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
    public function testCommentAttributosCorrectos(Comment $comment)
    {
        $comentario = $comment->getComentario();
        $comment_prueba = "es un comentario de prueba";
        $post_prueba = "esto es un texto de prueba";
        $post = $comment->getPost();
        $username = "eguerra";
        $this->assertEquals($comentario, $comment_prueba);
        $this->assertEquals($post->getPost(), $post_prueba);
        $this->assertEquals($comment->getUser()->getUsername(), $username);
        $this->assertInstanceOf(Post::class, $comment->getPost());
    }
    #[DataProvider('CommentProvider')]
    public function testSerializar(Comment $comment): array
    {

        $serializado = $comment->serializar();
        $text_prueba = "es un comentario de prueba";
        $username = "eguerra";
        $this->assertIsArray($serializado);
        $this->assertEquals($serializado['user']["username"], $username);
        $this->assertEquals($serializado['comentario'], $text_prueba);
        return $serializado;
    }
    #[DataProvider('CommentProvider')]
    public function testDeserializar(Comment $comment)
    {

        $serializado = $comment->serializar();
        $comentario = Comment::deserializar($serializado);
        $comentario = $comment->getComentario();
        $text_prueba = "es un comentario de prueba";
        $username = "eguerra";
        $this->assertEquals($comentario, $text_prueba);
        $this->assertEquals($comment->getUser()->getUsername(), $username);
        $this->assertInstanceOf(Post::class, $comment->getPost());
    }
}
