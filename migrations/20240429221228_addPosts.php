<?php

use App\config\Migrador;

class AddPosts extends Migrador
{
    public string $table = 'posts';
    public function up()
    {
        $sql = "INSERT INTO $this->table (titulo, descripcion, picture, id_user,  likes, dislikes  ) VALUES
        ('Aventuras en la naturaleza', 'Explorando nuevos senderos y disfrutando del aire libre.', 'imagen1.jpg', 3, 120, 5),
('Receta de la semana: Paella española', 'Una deliciosa receta para compartir en familia.', 'imagen2.jpg', 10, 75, 2),
('Último día de clases!', 'Celebrando el fin de un gran semestre.', 'imagen3.jpg', 15, 220, 8),
('Concierto de rock en vivo', 'Una noche llena de energía y buena música.', 'imagen4.jpg', 8, 180, 12),
('Nuevo proyecto en marcha', 'Empezando con entusiasmo un proyecto innovador.', 'imagen5.jpg', 5, 90, 3),
('Vacaciones en la playa', 'Disfrutando del sol y la arena.', 'imagen6.jpg', 12, 150, 10),
('Exposición de arte contemporáneo', 'Descubriendo nuevas formas de expresión artística.', 'imagen7.jpg', 7, 110, 6),
('Primer día de universidad', 'Emocionado por el inicio de una nueva etapa.', 'imagen8.jpg', 18, 200, 4),
('Entrenamiento para maratón', 'Preparándome para mi próximo desafío deportivo.', 'imagen9.jpg', 4, 80, 7),
('Visita a un parque temático', 'Diversión garantizada para toda la familia.', 'imagen10.jpg', 14, 120, 9),
('Celebración de cumpleaños', 'Un día especial rodeado de amigos y familiares.', 'imagen11.jpg', 6, 100, 5),
('Excursión a la montaña', 'Explorando la naturaleza en su estado más salvaje.', 'imagen12.jpg', 11, 130, 8),
('Festival de música electrónica', 'Noche épica con los mejores DJ del mundo.', 'imagen13.jpg', 9, 170, 15),
('Conferencia sobre inteligencia artificial', 'Aprendiendo sobre las últimas innovaciones en IA.', 'imagen14.jpg', 17, 190, 6),
('Preparativos para Navidad', 'Decorando la casa y comprando regalos.', 'imagen15.jpg', 2, 85, 3),
('Viaje cultural por Europa', 'Descubriendo la historia y la cultura de diferentes países.', 'imagen16.jpg', 13, 140, 12),
('Partido de fútbol emocionante', 'Vibrando con cada jugada del equipo favorito.', 'imagen17.jpg', 1, 95, 4),
('Sesión de fotos en la naturaleza', 'Capturando la belleza del paisaje en cada imagen.', 'imagen18.jpg', 16, 110, 7),
('Fiesta de fin de año', 'Celebrando el comienzo de un nuevo año con amigos.', 'imagen19.jpg', 8, 160, 10),
('Proyecto de voluntariado en comunidad', 'Contribuyendo positivamente al entorno local.', 'imagen20.jpg', 3, 70, 6),
('Experiencia gastronómica única', 'Degustando platos tradicionales en un restaurante exclusivo.', 'imagen21.jpg', 10, 130, 8),
('Concierto de banda local', 'Apoyando a talentos emergentes en la escena musical.', 'imagen22.jpg', 15, 180, 15),
('Tour en bicicleta por la ciudad', 'Explorando rincones ocultos y monumentos históricos.', 'imagen23.jpg', 5, 120, 9),
('Feria de tecnología y innovación', 'Descubriendo las últimas tendencias tecnológicas.', 'imagen24.jpg', 12, 150, 6),
('Reunión familiar en el campo', 'Disfrutando de la compañía de seres queridos en la naturaleza.', 'imagen25.jpg', 7, 90, 3),
('Competencia de surf', 'Desafiando las olas y buscando la mejor ola del día.', 'imagen26.jpg', 18, 100, 5),
('Seminario de emprendimiento', 'Aprendiendo estrategias para lanzar un negocio exitoso.', 'imagen27.jpg', 4, 110, 8),
('Visita a un museo de arte moderno', 'Explorando las obras maestras contemporáneas.', 'imagen28.jpg', 14, 140, 12),
('Carrera benéfica por la salud mental', 'Corriendo por una buena causa y apoyando la salud mental.', 'imagen29.jpg', 6, 200, 10),
('Concierto acústico en pequeño bar', 'Disfrutando de la música en un ambiente íntimo.', 'imagen30.jpg', 11, 80, 7);
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
