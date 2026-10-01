<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Nucleo\Conexion;
use App\Nucleo\ControladorBase;
use App\Nucleo\Vista;
use App\Repositorios\RepositorioCuenta;
use App\Servicios\ServicioCuenta;

final class CuentaControlador extends ControladorBase
{
    private ServicioCuenta $servicio;

    public function __construct()
    {
        $pdo = Conexion::obtener();

        $this->servicio = new ServicioCuenta(
            $pdo,
            new RepositorioCuenta($pdo),
            new \App\Repositorios\RepositorioUsuario($pdo),
            new \App\Repositorios\RepositorioRetiro($pdo),
            new \App\Repositorios\RepositorioTransferencia($pdo)
        );
    }

    public function panelAccion(): void
    {
        $cuentaId = $this->exigirSesion();
        $cuenta = $this->servicio->obtenerPanel($cuentaId);

        Vista::render('panel', [
            'titulo' => 'Mi cuenta',
            'cuenta' => $cuenta,
        ]);
    }
}
