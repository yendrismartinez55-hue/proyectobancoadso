<?php
declare(strict_types=1);

namespace App\Repositorios;

use App\Nucleo\Conexion;
use PDO;

final class RepositorioCliente
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function obtenerPorId(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, nombre FROM clientes WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }
}
