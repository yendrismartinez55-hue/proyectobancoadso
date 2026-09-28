<?php
declare(strict_types=1);
namespace App\Modelo;

final class Transferencia
{
    public function __construct(
        private int $id,
        private int $cuentaOrigenId,
        private int $cuentaDestinoId,
        private string $valor,
        private string $fecha
    ) {
    }

    public function obtenerId(): int
    {
        return $this->id;
    }

    public function obtenerCuentaOrigenId(): int
    {
        return $this->cuentaOrigenId;
    }

    public function obtenerCuentaDestinoId(): int
    {
        return $this->cuentaDestinoId;
    }

    public function obtenerValor(): string
    {
        return $this->valor;
    }

    public function obtenerFecha(): string
    {
        return $this->fecha;
    }
}