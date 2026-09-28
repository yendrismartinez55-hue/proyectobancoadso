<?php
declare(strict_types=1);

namespace App\Nucleo;

use App\Controladores\AutenticacionControlador;
use App\Controladores\CuentaControlador;
use App\Controladores\RetiroControlador;
use App\Controladores\TransferenciaControlador;

final class Router
{
    public function despachar(): void
    {
        $ruta = trim((string) ($_GET['ruta'] ?? 'autenticacion/login'), '/');
        $partes = $ruta === '' ? [] : explode('/', $ruta);

        $mapa = [
            'autenticacion' => AutenticacionControlador::class,
            'cuenta' => CuentaControlador::class,
            'retiro' => RetiroControlador::class,
            'transferencia' => TransferenciaControlador::class,
        ];

        $controladorClave = $partes[0] ?? 'autenticacion';
        $accion = $partes[1] ?? 'login';

        if (!isset($mapa[$controladorClave])) {
            $this->error404();
            return;
        }

        $controlador = new $mapa[$controladorClave]();

        if (!method_exists($controlador, $accion . 'Accion')) {
            $this->error404();
            return;
        }

        $metodo = $accion . 'Accion';
        $controlador->$metodo();
    }

    private function error404(): void
    {
        http_response_code(404);
        Vista::render('errores/404', [
            'titulo' => 'Página no encontrada',
        ]);
    }
}
