<?php

use App\config\Migrador;


class AddForeignKeyUserRol extends Migrador
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = "alter table users add constraint 
        FK_RolUser foreign key (`id_rol`) 
        references roles(`id`);";
        $this->run($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "alter table users drop constraint FK_RolUser;";
        $this->run($sql);
    }
}
