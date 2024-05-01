<?php

use App\config\Migrador;

class TriggerUpdateComment extends Migrador
{
    /**
     * Do the migration
     */
    public function up()
    {

        $sql = "CREATE TRIGGER `before_comment_update` 
        before UPDATE ON `comments` 
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
        $sql = "DROP TRIGGER `before_comment_update`";
        $this->run($sql);
    }
}
