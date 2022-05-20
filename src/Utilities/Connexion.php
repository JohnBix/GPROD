<?php

namespace App\Utilities;

use PDO;

class Connexion {

    public static function getPDO(): PDO
    {
        return new PDO("mysql:dbname=gprod;host=localhost", "lebotomysql", "LeBoto@Mysql_1234", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
}