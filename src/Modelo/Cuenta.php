<?php
declare(strict_types=1);
namespace App\Modelos;

final class Cuenta
{
    public function __construct(
        private int $id,
        private string $numeroCuenta,
        private string $saldo,
        private int $clienteId
    ) {
    }

    public function obtenerId(): int
    {
        return $this->id;
    }

    public function obtenerNumeroCuenta(): string
    {
        return $this->numeroCuenta;
    }

    public function obtenerSaldo(): string
    {
        return $this->saldo;
    }

    public function obtenerClienteId(): int
    {
        return $this->clienteId;
    }
}
