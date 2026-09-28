<?php
declare(strict_types=1);
namespace App\Modelo;


final class Retiro
{
    public function __construct(
        private int $id,
        private int $cuentaId,
        private string $valor,
        private string $fecha
    ) {
    }

    public function obtenerId(): int
    {
        return $this->id;
    }

    public function obtenerCuentaId(): int
    {
        return $this->cuentaId;
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
