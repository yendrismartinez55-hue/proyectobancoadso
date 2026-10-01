<?php
declare(strict_types=1);

namespace App\Controladores;

use App\Excepciones\CredencialesInvalidasException;
use App\Excepciones\CuentaNoEncontradaException;
use App\Excepciones\MismaCuentaException;
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

final class TransferenciaControlador extends ControladorBase
{
    private ServicioCuenta $servicio;
    private RepositorioTransferencia $transferencias;

    public function __construct()
    {
        $pdo = Conexion::obtener();

        $this->transferencias = new RepositorioTransferencia($pdo);

        $this->servicio = new ServicioCuenta(
            $pdo,
            new RepositorioCuenta($pdo),
            new RepositorioUsuario($pdo),
            new RepositorioRetiro($pdo),
            $this->transferencias
        );
    }

    public function formularioAccion(): void
    {
        $this->exigirSesion();

        $error = $_SESSION['error'] ?? null;
        $exito = $_SESSION['exito'] ?? null;
        unset($_SESSION['error'], $_SESSION['exito']);

        Vista::render('transferencias/formulario', [
            'titulo' => 'Realizar transferencia',
            'error' => $error,
            'exito' => $exito,
        ]);
    }

    public function guardarAccion(): void
    {
        $cuentaOrigenId = $this->exigirSesion();

        $numeroCuentaDestino = trim(
            (string) ($_POST['numero_cuenta_destino'] ?? '')
        );
        $valor = (string) ($_POST['valor'] ?? '');
        $clave = (string) ($_POST['clave'] ?? '');

        try {
            $this->servicio->transferir(
                $cuentaOrigenId,
                $numeroCuentaDestino,
                $valor,
                $clave
            );

            $_SESSION['exito'] = 'Transferencia realizada correctamente.';
        } catch (
            CredencialesInvalidasException |
            CuentaNoEncontradaException |
            MismaCuentaException |
            SaldoInsuficienteException |
            ValorInvalidoException $e
        ) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: ?ruta=transferencia/formulario');
        exit;
    }

    public function historialAccion(): void
    {
        $cuentaId = $this->exigirSesion();

        $historial = $this->transferencias->obtenerEnviadas($cuentaId);
        $resumen = $this->transferencias->obtenerResumenEnviadas($cuentaId);

        Vista::render('transferencias/historial', [
            'titulo' => 'Historial de transferencias',
            'historial' => $historial,
            'resumen' => $resumen,
        ]);
    }
}
