<?php
/** @var array $resumen */
/** @var array $historial */
?>
<div class="cabecera">
    <h1>Transferencias enviadas</h1>
    <nav>
        <a href="?ruta=cuenta/panel">Inicio</a>
        <a href="?ruta=transferencia/formulario">Nueva transferencia</a>
    </nav>
</div>

<div class="tarjeta">
    <p><strong>Total de transferencias:</strong> <?= e($resumen['cantidad']) ?></p>
    <p><strong>Total transferido:</strong> $ <?= e(number_format((float) $resumen['total'], 2, ',', '.')) ?></p>
</div>

<div class="tarjeta">
    <?php if ($historial === []): ?>
        <p>No hay transferencias registradas.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cuenta destino</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($historial as $transferencia): ?>
                <tr>
                    <td><?= e($transferencia['fecha']) ?></td>
                    <td><?= e($transferencia['cuenta_destino']) ?></td>
                    <td>$ <?= e(number_format((float) $transferencia['valor'], 2, ',', '.')) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
