<?php

declare(strict_types=1);

namespace App\Nucleo;

use PDO;
use PDOException;

final class Conexion
{
    public static function obtener(): PDO
    {
        try {
            return new PDO(
                'mysql:host=127.0.0.1;dbname=db_banco_adso;charset=utf8mb4',
                'root',
                'Adso2026*',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}