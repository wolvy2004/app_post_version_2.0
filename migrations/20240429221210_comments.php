<?php


use App\config\Migrador;

class Comments extends Migrador
{
    public string $table = 'comments';
    public function up()
    {

        $sql = "CREATE TABLE $this->table (
            `comentario` varchar(255) NOT NULL,
            `id_user` int(11) NOT NULL,
            `id_post`  int(11) not null,
            `id` int(11) NOT NULL auto_increment,
            `created_at` datetime NOT NULL default now(),
            `updated_at` datetime DEFAULT NULL,
            `is_active` int(1) NOT NULL default 1,
            CONSTRAINT PK_COMMENT Primary Key(id),
            CONSTRAINT FK_COMMENT_USER FOREIGN KEY (id_user) REFERENCES USERS (id),
            CONSTRAINT FK_COMMENT_POST FOREIGN KEY (id_post) REFERENCES POST (id)
            );";
        $this->run($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "drop table if exists $this->table";
        $this->run($sql);
    }
}
