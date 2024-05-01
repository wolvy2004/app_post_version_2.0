<?php

declare(strict_types=1);
require_once __DIR__ . '../../../vendor/autoload.php';

use App\config\DBConect;

$table = "users";
$sql = "
create table $table(
    `id` int(4) not null auto_increment PRIMARY KEY,
    `username` varchar(100) not null UNIQUE,
    `password` varchar(255) not null,
    `created_at` timestamp not null default now(),
    `updated_at` timestamp default null,
    `is_active` int(1) not null default 1,
    `rol` int(4) not null default 1
)";

print_r(DBConect::write(sql: $sql));
