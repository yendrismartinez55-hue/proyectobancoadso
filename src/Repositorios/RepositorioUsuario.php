<?php
declare(strict_types=1);

namespace App\Repositorios;

use PDO;

final class RepositorioUsuario
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function obtenerPorCuentaId(int $cuentaId): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, cuenta_id, clave_hash
             FROM usuarios
             WHERE cuenta_id = :cuenta_id'
        );
        $stmt->execute(['cuenta_id' => $cuentaId]);

        return $stmt->fetch() ?: null;
    }
}
