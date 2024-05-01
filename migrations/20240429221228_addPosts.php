<?php

use App\config\Migrador;

class AddPosts extends Migrador
{
    public string $table = 'posts';
    public function up()
    {
        $sql = "INSERT INTO $this->table (post, likes, dislikes, id_user, picture) VALUES
        ('Hoy fue un día increíble en la playa', 120, 5, 1, 'playa.jpg'),
        ('Acabo de terminar de leer un gran libro', 87, 3, 2, 'libro.jpg'),
        ('Qué hermosa es la naturaleza en primavera', 210, 8, 3, 'naturaleza.jpg'),
        ('¡Nuevo récord personal en el gimnasio!', 175, 12, 4, 'gimnasio.jpg'),
        ('Viendo una película clásica con amigos', 98, 2, 5, 'pelicula.jpg'),
        ('¡Feliz cumpleaños a mi mejor amigo!', 350, 15, 6, 'cumpleaños.jpg'),
        ('Probé una nueva receta y me encantó', 145, 7, 7, 'receta.jpg'),
        ('¡Concierto épico esta noche!', 280, 20, 8, 'concierto.jpg'),
        ('Viajando por Europa, ¡qué experiencia!', 420, 18, 9, 'europa.jpg'),
        ('Estudiando para el examen final, deséame suerte', 65, 4, 10, 'estudio.jpg'),
        ('De compras en las rebajas de fin de temporada', 180, 9, 11, 'compras.jpg'),
        ('Comenzando un nuevo proyecto creativo', 220, 10, 12, 'proyecto.jpg'),
        ('Partido emocionante de fútbol esta tarde', 300, 25, 13, 'futbol.jpg'),
        ('Disfrutando de un día de spa y relajación', 150, 6, 14, 'spa.jpg'),
        ('Aprendiendo a tocar guitarra, ¡es todo un reto!', 110, 3, 15, 'guitarra.jpg'),
        ('Recorriendo las calles de Tokio, ¡qué ciudad tan vibrante!', 400, 22, 16, 'tokio.jpg'),
        ('Maratón de series con mi pareja, ¡qué tarde perfecta!', 250, 13, 17, 'series.jpg'),
        ('Celebrando el éxito del nuevo lanzamiento de la empresa', 190, 11, 18, 'empresa.jpg'),
        ('De excursión en las montañas, ¡las vistas son impresionantes!', 380, 17, 19, 'montañas.jpg'),
        ('Descubriendo nuevos restaurantes en la ciudad', 135, 5, 20, 'restaurantes.jpg');
        ";
        $this->run($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "TRUNCATE TABLE $this->table";
        $this->run($sql);
    }
}
