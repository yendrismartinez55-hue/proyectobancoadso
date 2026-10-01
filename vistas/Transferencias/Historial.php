<div class="cabecera">

    <h1>Transferencias enviadas</h1>

    <nav>
        <a href="?ruta=cuenta/panel">Inicio</a>

        <a href="?ruta=transferencia/formulario">
            Nueva transferencia
        </a>
    </nav>

</div>


<div class="tarjeta">

    <p>
        <strong>Total de transferencias:</strong>
        <?= (int) ($resumen['cantidad'] ?? 0) ?>
    </p>

    <p>
        <strong>Total transferido:</strong>
        $
        <?= htmlspecialchars(
            number_format(
                (float) ($resumen['total'] ?? 0),
                2,
                ',',
                '.'
            )
        ) ?>
    </p>

</div>


<div class="tarjeta">

    <?php if (empty($historial)): ?>

        <p>No hay transferencias registradas.</p>

    <?php else: ?>

        <table>

            <thead>

                <tr>
                    <th>Fecha</th>
                    <th>Cuenta origen</th>
                    <th>Cuenta destino</th>
                    <th>Valor</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($historial as $transferencia): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars(
                                (string) $transferencia['fecha']
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                (string) $transferencia['cuenta_origen']
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                (string) $transferencia['cuenta_destino']
                            ) ?>
                        </td>

                        <td>
                            $
                            <?= htmlspecialchars(
                                number_format(
                                    (float) $transferencia['valor'],
                                    2,
                                    ',',
                                    '.'
                                )
                            ) ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

</div>
