<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Nucleo\Conexion;

$conexion = Conexion::obtener();

$usuarios = [
    [
        'cuenta_id' => 1,
        'clave' => '123'
    ],
    [
        'cuenta_id' => 2,
        'clave' => '456'
    ],
    [
        'cuenta_id' => 3,
        'clave' => '789'
    ],
    [
        'cuenta_id' => 4,
        'clave' => '321'
    ],
    [
        'cuenta_id' => 5,
        'clave' => '432'
    ]
];

$sql = "
    INSERT INTO usuarios (cuenta_id, clave_hash)
    VALUES (:cuenta_id, :clave_hash)
";

$sentencia = $conexion->prepare($sql);

foreach ($usuarios as $usuario) {

    $claveHash = password_hash(
        $usuario['clave'],
        PASSWORD_DEFAULT
    );

    $sentencia->execute([
        'cuenta_id' => $usuario['cuenta_id'],
        'clave_hash' => $claveHash
    ]);
}

echo "Usuarios creados correctamente con contraseñas hasheadas." . "\n";