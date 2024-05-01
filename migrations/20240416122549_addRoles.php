<?php

use App\config\Migrador;

class AddRoles extends Migrador
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = "INSERT INTO roles (descripcion) VALUES ('admin'), ('visitor'), ('superadmin'), ('redact')";
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
