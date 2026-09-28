<?php
declare(strict_types=1);

function e(string|int|float|null $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

function redirigir(string $ruta): never
{
    header('Location: ' . $ruta);
    exit;
}
