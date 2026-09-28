<?php
declare(strict_types=1);

namespace App\Nucleo;

final class Vista
{
    public static function render(string $vista, array $datos = []): void
    {
        extract($datos, EXTR_SKIP);

        $contenido = dirname(__DIR__, 2) . '/vistas/' . $vista . '.php';

        if (!is_file($contenido)) {
            http_response_code(500);
            echo 'Vista no encontrada.';
            return;
        }

        require dirname(__DIR__, 2) . '/vistas/layout.php';
    }
}
