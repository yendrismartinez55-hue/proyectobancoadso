<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Excepciones\CredencialesInvalidasException;
use App\Excepciones\CuentaNoEncontradaException;
use App\Excepciones\SaldoInsuficienteException;
use App\Excepciones\ValorInvalidoException;
use App\Nucleo\Conexion;
use App\Nucleo\ControladorBase;
use App\Nucleo\Vista;
use App\Repositorios\RepositorioCuenta;
use App\Repositorios\RepositorioRetiro;
use App\Repositorios\RepositorioTransferencia;
use App\Repositorios\RepositorioUsuario;
use App\Servicios\ServicioCuenta;

final class RetiroControlador extends ControladorBase
{
    private ServicioCuenta $servicio;
    private RepositorioRetiro $retiros;

    public function __construct()
    {
        $pdo = Conexion::obtener();

        $this->retiros = new RepositorioRetiro($pdo);

        $this->servicio = new ServicioCuenta(
            $pdo,
            new RepositorioCuenta($pdo),
            new RepositorioUsuario($pdo),
            $this->retiros,
            new RepositorioTransferencia($pdo)
        );
    }

    public function formularioAccion(): void
    {
        $this->exigirSesion();

        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);

        Vista::render('retiros/formulario', [
            'titulo' => 'Realizar retiro',
            'error' => $error,
        ]);
    }

    public function guardarAccion(): void
    {
        $cuentaId = $this->exigirSesion();

        $valor = (string) ($_POST['valor'] ?? '');
        $clave = (string) ($_POST['clave'] ?? '');

        try {
            $this->servicio->retirar($cuentaId, $valor, $clave);
            $_SESSION['exito'] = 'Retiro realizado correctamente.';
        } catch (
            CredencialesInvalidasException |
            CuentaNoEncontradaException |
            SaldoInsuficienteException |
            ValorInvalidoException $e
        ) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: ?ruta=retiro/formulario');
        exit;
    }

    public function historialAccion(): void
    {
        $cuentaId = $this->exigirSesion();

        $historial = $this->retiros->obtenerHistorial($cuentaId);
        $resumen = $this->retiros->obtenerResumen($cuentaId);

        Vista::render('retiros/historial', [
            'titulo' => 'Historial de retiros',
            'historial' => $historial,
            'resumen' => $resumen,
        ]);
    }
}
