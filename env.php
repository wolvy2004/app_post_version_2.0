<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required(['DB_NAME', 'DB_USER', 'DB_PASS', 'SECRET_KEY']);
