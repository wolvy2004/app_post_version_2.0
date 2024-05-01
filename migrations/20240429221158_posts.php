<?php

use App\config\Migrador;

class Posts extends Migrador
{
    /**
     * Do the migration
     */
    public string $table = 'posts';
    public function up()
    {

        $sql = "CREATE TABLE $this->table (
            `id` int(11) NOT NULL auto_increment,
            `created_at` datetime NOT NULL default now(),
            `updated_at` datetime DEFAULT NULL,
            `is_active` int(1) NOT NULL default 1,
            `id_user` int(11) NOT NULL,
            `post`  varchar(255) not null,
            `likes` int(10) not null default 0,
            `dislikes` int(10) not null default 0 ,
            `picture` varchar(100) default NULL,
            CONSTRAINT PK_POST Primary Key(id),
            CONSTRAINT FK_POST_USER FOREIGN KEY (id_user) REFERENCES USERS (id)
            );";
        $this->run($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "DROP TABLE IF EXISTS $this->table";
        $this->run($sql);
    }
}
