<?php
declare(strict_types=1);

namespace App\Nucleo;

abstract class ControladorBase
{
    protected function exigirSesion(): int
    {
        if (!isset($_SESSION['cuenta_id']) || !is_int($_SESSION['cuenta_id'])) {
            header('Location: ?ruta=autenticacion/login');
            exit;
        }

        return $_SESSION['cuenta_id'];
    }

    protected function redirigir(string $ruta): never
    {
        header("Location: $ruta");
        exit;   
    }
}
