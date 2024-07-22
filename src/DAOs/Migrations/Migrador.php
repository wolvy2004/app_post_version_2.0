<?php

declare(strict_types=1);

namespace App\DAOs\Migrations;

use Phpmig\Migration\Migration;

class Migrador extends Migration
{
    public function run(string $sql)
    {
        $container = $this->getContainer();
        /** @var PDO */
        $db = $container['db'];
        $db->query('SET FOREIGN_KEY_CHECKS = 0;');
        $statement = $db->query($sql);
        $db->query('SET FOREIGN_KEY_CHECKS = 1;');
        $statement->closeCursor();
    }
}
