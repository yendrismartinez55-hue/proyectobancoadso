<?php

declare(strict_types=1);

namespace App\Repositorios;

use PDO;

final class RepositorioCuenta
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function obtenerPorNumero(string $numeroCuenta): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT 
                id,
                numero_cuenta,
                saldo,
                cliente_id
             FROM cuentas
             WHERE numero_cuenta = :numero_cuenta'
        );

        $stmt->execute([
            'numero_cuenta' => $numeroCuenta
        ]);

        return $stmt->fetch() ?: null;
    }

    public function obtenerPorId(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT 
                cuentas.id,
                cuentas.numero_cuenta,
                cuentas.saldo,
                cuentas.cliente_id,
                clientes.nombre
             FROM cuentas
             INNER JOIN clientes
                ON clientes.id = cuentas.cliente_id
             WHERE cuentas.id = :id'
        );

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch() ?: null;
    }

    public function descontar(int $id, string $valor): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE cuentas
             SET saldo = saldo - :valor
             WHERE id = :id
             AND saldo >= :valor'
        );

        $stmt->execute([
            'valor' => $valor,
            'id' => $id,
        ]);

        if ($stmt->rowCount() !== 1) {
            throw new \RuntimeException(
                'No fue posible descontar el saldo.'
            );
        }
    }

    public function abonar(int $id, string $valor): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE cuentas
             SET saldo = saldo + :valor
             WHERE id = :id'
        );

        $stmt->execute([
            'valor' => $valor,
            'id' => $id,
        ]);

        if ($stmt->rowCount() !== 1) {
            throw new \RuntimeException(
                'No fue posible abonar el saldo.'
            );
        }
    }
}

