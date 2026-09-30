<?php

declare(strict_types=1);

namespace App\Servicios;

use App\Repositorios\RepositorioCuenta;
use App\Repositorios\RepositorioUsuario;

final class ServicioAutenticacion
{
    public function __construct(
        private readonly RepositorioCuenta $cuentas,
        private readonly RepositorioUsuario $usuarios
    ) {
    }

    public function autenticar(
        string $numeroCuenta,
        string $clave
    ): int {
        $cuenta = $this->cuentas->obtenerPorNumero($numeroCuenta);

        if ($cuenta === null) {
            throw new \RuntimeException(
                'Número de cuenta o contraseña incorrectos.'
            );
        }

        $usuario = $this->usuarios->obtenerPorCuentaId(
            (int) $cuenta['id']
        );

        if ($usuario === null || $clave !== $usuario['clave_hash']) {
            throw new \RuntimeException(
                'Número de cuenta o contraseña incorrectos.'
            );
            }

        return (int) $cuenta['id'];
    }
}