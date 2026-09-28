<?php
declare(strict_types=1);

namespace App\Repositorios;

use PDO;

final class RepositorioRetiro
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function registrar(int $cuentaId, string $valor): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO retiros (cuenta_id, valor)
             VALUES (:cuenta_id, :valor)'
        );
        $stmt->execute([
            'cuenta_id' => $cuentaId,
            'valor' => $valor,
        ]);
    }

    public function obtenerHistorial(int $cuentaId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, cuenta_id, valor, fecha
             FROM retiros
             WHERE cuenta_id = :cuenta_id
             ORDER BY fecha DESC, id DESC'
        );
        $stmt->execute(['cuenta_id' => $cuentaId]);

        return $stmt->fetchAll();
    }

    public function obtenerResumen(int $cuentaId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT COUNT(*) AS cantidad,
                    COALESCE(SUM(valor), 0.00) AS total
             FROM retiros
             WHERE cuenta_id = :cuenta_id'
        );
        $stmt->execute(['cuenta_id' => $cuentaId]);

        return $stmt->fetch() ?: ['cantidad' => 0, 'total' => '0.00'];
    }
}
