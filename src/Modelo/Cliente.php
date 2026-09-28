<?php
declare(strict_types=1);

namespace App\Modelo;

final class Cliente
{
    public function __construct(
        private int $id,
        private string $nombre
    ) {
    }

    public function obtenerId(): int
    {
        return $this->id;
    }

    public function obtenerNombre(): string
    {
        return $this->nombre;
    }
}