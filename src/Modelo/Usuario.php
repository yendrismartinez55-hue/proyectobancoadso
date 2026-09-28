<?php
declare(strict_types=1);

namespace App\Modelos;

final class Usuario
{
    public function __construct(
        private  int $id,
        private  int $cuentaId,
        private  string $claveHash
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

    public function obtenerClaveHash(): string
    {
        return $this->claveHash;
    }
}

