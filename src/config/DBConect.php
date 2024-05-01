<?php

declare(strict_types=1);

namespace App\config;

use PDO;
use PDOException;
use PDOStatement;

class DBConect
{
    static ?PDO $cnx = null;

    static function conectarDB(): ?PDO
    {

        try {

            $host = "localhost";
            $db = $_ENV["DB_NAME"];
            $user = $_ENV["DB_USER"];
            $pass = $_ENV["DB_PASS"];
            $dns = "mysql:host=$host;dbname=$db";
            Self::$cnx = new PDO($dns, $user, $pass);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return self::$cnx;
    }
    // metodo para lectura de registros
    static function read(string $sql, array $params = []): false|array
    {
        $dbh = self::conectarDB();
        $stmt = $dbh->prepare($sql);
        $stmt->execute($params);
        // cerramos la conexion

        return $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    }
    static function write(string $sql, array $params = []): int
    {
        $dbh = self::conectarDB();
        $stmt = $dbh->prepare(query: $sql);
        $stmt->execute(params: $params);
        $resultado = $stmt->rowCount();
        // cerramos la conexion
        self::$cnx = null;
        $stmt->closeCursor();
        return $resultado;
    }
}
