<h1>Mi cuenta</h1>

<?php if (!empty($cuenta)): ?>

    <h2>
        Bienvenido, <?= htmlspecialchars($cuenta['nombre']) ?>
    </h2>

    <p>
        <strong>Número de cuenta:</strong>
        <?= htmlspecialchars($cuenta['numero_cuenta']) ?>
    </p>

    <p>
        <strong>Saldo disponible:</strong>
        $<?= number_format(
            (float) $cuenta['saldo'],
            2,
            ',',
            '.'
        ) ?>
    </p>

    <hr>

    <h2>Menú</h2>

    <p>
        <a class="enlace-menu" href="?ruta=retiro/formulario">Realizar retiro</a>
    </p>

    <p>
        <a class="enlace-menu" href="?ruta=transferencia/formulario">Realizar transferencia</a>
    </p>

    <hr>

    <h2>Historial</h2>

    <p>
        <a class="enlace-menu" href="?ruta=retiro/historial">Historial de retiros</a>
    </p>

    <p>
        <a class="enlace-menu" href="?ruta=transferencia/historial">Historial de transferencias</a>
    </p>

    <hr>

    <p>
        <a href="?ruta=autenticacion/salir">
            <button type="button">
                Cerrar sesión
            </button>
        </a>
    </p>

<?php else: ?>

    <p>No se encontraron los datos de la cuenta.</p>

<?php endif; ?>

