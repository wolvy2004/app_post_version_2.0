<?php

use App\config\Migrador;

class TriggerUpdateUser extends Migrador
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = "CREATE TRIGGER `before_user_update` 
        before UPDATE ON `users` 
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
        $sql = "DROP TRIGGER `before_user_update`";
        $this->run($sql);
    }
}
