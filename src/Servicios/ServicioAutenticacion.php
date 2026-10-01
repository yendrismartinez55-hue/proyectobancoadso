<?php
declare(strict_types=1);

namespace App\Servicios;

use App\Repositorios\RepositorioCuenta;
use App\Repositorios\RepositorioUsuario;

final class ServicioAutenticacion
{
    private RepositorioCuenta $cuentas;
    private RepositorioUsuario $usuarios;

    public function __construct(
        RepositorioCuenta $cuentas,
        RepositorioUsuario $usuarios
    ) {
        $this->cuentas = $cuentas;
        $this->usuarios = $usuarios;
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

        if ($usuario === null) {
            throw new \RuntimeException(
                'Número de cuenta o contraseña incorrectos.'
            );
        }

        $claveCorrecta = password_verify(
            $clave,
            $usuario['clave_hash']
        );

        if (!$claveCorrecta) {
            throw new \RuntimeException(
                'Número de cuenta o contraseña incorrectos.'
            );
        }

        return (int) $cuenta['id'];
    }
}
