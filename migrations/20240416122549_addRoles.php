<?php

use App\config\Migrador;

class AddRoles extends Migrador
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = "INSERT INTO roles (descripcion) VALUES ('public'), ('admin'), ('super admin') ";
        $this->run($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "TRUNCATE TABLE roles";
        $this->run($sql);
    }
}
