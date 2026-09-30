<div class="cabecera">
    <h1>Historial de retiros</h1>
    <nav>
        <a href="?ruta=cuenta/panel">Inicio</a>
        <a href="?ruta=retiro/formulario">Nuevo retiro</a>
    </nav>
</div>

<div class="tarjeta">
    <p><strong>Total de retiros:</strong> <?= ($resumen['cantidad']) ?></p>
    <p><strong>Total retirado:</strong> $ <?= (number_format((float) $resumen['total'], 2, ',', '.')) ?></p>
</div>

<div class="tarjeta">
    <?php if ($historial === []): ?>
        <p>No hay retiros registrados.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($historial as $retiro): ?>
                <tr>
                    <td><?= ($retiro['fecha']) ?></td>
                    <td>$ <?= (number_format((float) $retiro['valor'], 2, ',', '.')) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
