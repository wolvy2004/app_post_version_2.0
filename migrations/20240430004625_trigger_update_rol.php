<?php

use App\config\Migrador;

class TriggerUpdateRol extends Migrador
{
    /**
     * Do the migration
     */
    public function up()
    {

        $sql = "CREATE TRIGGER `before_rol_update` 
        before UPDATE ON `roles` 
            FOR EACH ROW 
        begin
            SET new.updated_at = CURRENT_TIMESTAMP ; 
        end";
        $this->run($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "DROP TRIGGER `before_rol_update`";
        $this->run($sql);
    }
}
