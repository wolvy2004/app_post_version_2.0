<?php

use App\config\Migrador;

class AddComments extends Migrador
{
    /**
     * Do the migration
     */
    public string $table = 'comments';
    public function up()
    {
        $sql = "INSERT INTO $this->table (comentario, id_user, id_post) VALUES
        ('Qué envidia, me encantaría estar en la playa ahora mismo', 1, 1),
        ('Eso suena genial, ¿qué libro era?', 2, 2),
        ('Las fotos de la naturaleza son siempre hermosas', 3, 3),
        ('¡Impresionante! ¿Cuál es tu rutina?', 4, 4),
        ('Las películas clásicas siempre son una buena elección', 5, 5),
        ('¡Feliz cumpleaños! Que tengas un día increíble', 6, 6),
        ('¿Qué receta probaste? ¡Me encanta cocinar!', 7, 7),
        ('¡Disfruta del concierto! ¿Quién está tocando?', 8, 8),
        ('¡Europa es increíble! ¿Qué países visitaste?', 9, 9),
        ('Buena suerte con el examen, ¡tú puedes!', 10, 10),
        ('Las rebajas son el mejor momento para ir de compras', 11, 11),
        ('¡Suena emocionante! ¿Qué tipo de proyecto es?', 12, 12),
        ('¡Vamos equipo! ¿Quién ganó al final?', 13, 13),
        ('¡Qué relajante! ¿Qué tratamientos probaste?', 14, 14),
        ('La guitarra es un instrumento maravilloso, ¿cómo vas con ella?', 15, 15),
        ('Tokio es una ciudad increíblemente vibrante, ¿qué lugares visitaste?', 16, 16),
        ('¡Suena como una tarde perfecta! ¿Qué series viste?', 17, 17),
        ('¡Felicidades por el éxito! ¿Cuál fue el lanzamiento?', 18, 18),
        ('Las montañas siempre tienen paisajes impresionantes', 19, 19),
        ('¡Descubrir nuevos restaurantes es una de mis actividades favoritas!', 20, 20),
        ('Eso suena como unas vacaciones perfectas', 1, 3),
        ('¿De qué género era la película?', 2, 5),
        ('¡Qué genial! ¿Cómo planeas celebrar?', 3, 6),
        ('¿Podrías compartir la receta? Me encantaría probarla', 4, 7),
        ('¡Disfruten del concierto! ¿Hay alguna canción que esperan escuchar?', 5, 8),
        ('¡Me encantaría visitar Europa algún día!', 6, 9),
        ('¡Buena suerte! Estoy seguro de que lo harás genial', 7, 10),
        ('Las rebajas siempre son una tentación, ¿qué compraste?', 8, 11),
        ('¡Qué emocionante! ¿Qué tipo de proyecto es?', 9, 12),
        ('¡Increíble! ¿Hubo algún gol emocionante?', 10, 13),
        ('¿Qué tratamientos hiciste en el spa?', 11, 14),
        ('¿Qué canciones estás aprendiendo?', 12, 15),
        ('¿Qué lugares recomendarías en Tokio?', 13, 16),
        ('¿Cuál fue la última serie que vieron?', 14, 17),
        ('¡Felicidades! ¿Cómo planean celebrar?', 15, 18),
        ('Las montañas son perfectas para desconectar', 16, 19),
        ('¿Cuál fue tu restaurante favorito de los que probaste?', 17, 20),
        ('Eso suena como unas vacaciones perfectas', 18, 3),
        ('¿Qué libro estás leyendo?', 19, 4),
        ('¡Qué bonito gesto! ¿Cómo lo celebraron?', 20, 6);";
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
