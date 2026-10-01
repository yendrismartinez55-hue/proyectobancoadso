<?php

declare(strict_types=1);

namespace App\Controladores;

use App\Nucleo\Conexion;
use App\Nucleo\Vista;
use App\Repositorios\RepositorioCuenta;
use App\Repositorios\RepositorioUsuario;
use App\Servicios\ServicioAutenticacion;

final class AutenticacionControlador
{
    private ServicioAutenticacion $servicio;

    public function __construct()
    {
        $pdo = Conexion::obtener();

        $this->servicio = new ServicioAutenticacion(
            new RepositorioCuenta($pdo),
            new RepositorioUsuario($pdo)
        );
    }

    public function loginAccion(): void
    {
        if (isset($_SESSION['cuenta_id'])) {
            header('Location: ?ruta=cuenta/panel');
            exit;
        }

        $error = $_SESSION['error'] ?? null;

        unset($_SESSION['error']);

        Vista::render('Login', [
            'titulo' => 'Inicio de sesión',
            'error' => $error
        ]);
    }

    public function autenticarAccion(): void
    {
        $numeroCuenta = trim(
            (string) ($_POST['numero_cuenta'] ?? '')
        );

        $clave = (string) ($_POST['clave'] ?? '');

        try {
            $cuentaId = $this->servicio->autenticar(
                $numeroCuenta,
                $clave
            );

            session_regenerate_id(true);

            $_SESSION['cuenta_id'] = $cuentaId;

            header('Location: ?ruta=cuenta/panel');
            exit;

        } catch (\RuntimeException $e) {

            $_SESSION['error'] =
                'Número de cuenta o contraseña incorrectos.';

            header('Location: ?ruta=autenticacion/login');
            exit;
        }
    }

    public function salirAccion(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $parametros = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $parametros['path'],
                $parametros['domain'],
                $parametros['secure'],
                $parametros['httponly']
            );
        }

        session_destroy();

        header('Location: ?ruta=autenticacion/login');
        exit;
    }
}
