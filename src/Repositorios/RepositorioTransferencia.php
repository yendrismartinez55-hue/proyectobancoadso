<?php

declare(strict_types=1);

namespace App\Repositorios;

use PDO;

final class RepositorioTransferencia
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function registrar(
        int $cuentaOrigenId,
        int $cuentaDestinoId,
        string $valor
    ): void {
        $stmt = $this->pdo->prepare(
            'INSERT INTO transferencias
                (cuenta_origen_id, cuenta_destino_id, valor)
             VALUES
                (:origen, :destino, :valor)'
        );

        $stmt->execute([
            'origen' => $cuentaOrigenId,
            'destino' => $cuentaDestinoId,
            'valor' => $valor,
        ]);
    }

    public function obtenerEnviadas(int $cuentaId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT
                t.id,
                t.valor,
                t.fecha,
                origen.numero_cuenta AS cuenta_origen,
                destino.numero_cuenta AS cuenta_destino
             FROM transferencias t
             INNER JOIN cuentas origen
                ON origen.id = t.cuenta_origen_id
             INNER JOIN cuentas destino
                ON destino.id = t.cuenta_destino_id
             WHERE t.cuenta_origen_id = :cuenta_id
             ORDER BY t.fecha DESC, t.id DESC'
        );

        $stmt->execute([
            'cuenta_id' => $cuentaId
        ]);

        return $stmt->fetchAll();
    }

    public function obtenerResumenEnviadas(int $cuentaId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT
                COUNT(*) AS cantidad,
                COALESCE(SUM(valor), 0.00) AS total
             FROM transferencias
             WHERE cuenta_origen_id = :cuenta_id'
        );

        $stmt->execute([
            'cuenta_id' => $cuentaId
        ]);

        return $stmt->fetch()
            ?: [
                'cantidad' => 0,
                'total' => '0.00'
            ];
    }
}
