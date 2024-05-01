<?php

use App\config\Migrador;

class TriggerUpdatePost extends Migrador
{
    /**
     * Do the migration
     */
    public function up()
    {

        $sql = "CREATE TRIGGER `before_post_update` 
        before UPDATE ON `posts` 
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
        $sql = "DROP TRIGGER `before_post_update`";
        $this->run($sql);
    }
}
