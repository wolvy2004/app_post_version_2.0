<?php

use App\config\Migrador;

class Roles extends Migrador
{

    public function up()
    {
        $sql = "CREATE TABLE Roles(
        `id` int(11) NOT NULL auto_increment,
        `descripcion`  varchar(100) not null unique,
        `created_at` datetime NOT NULL default now(),
        `updated_at` datetime default null,
        `is_active` int(1) NOT NULL default 1,
        CONSTRAINT PK_Rol PRIMARY KEY (`id`)        
         );";
        $this->run($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "drop table roles;";
        $this->run($sql);
    }
}
