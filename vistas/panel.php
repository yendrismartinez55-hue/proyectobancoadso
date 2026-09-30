
<div class="cabecera">
    <div>
        <h1>Banco ADSO</h1>
        <p>Cuenta <?= ($cuenta['numero_cuenta']) ?></p>
    </div>

    <nav>
        <a href="?ruta=cuenta/panel">Inicio</a>
        <a href="?ruta=retiro/formulario">Retirar</a>
        <a href="?ruta=retiro/historial">Retiros</a>
        <a href="?ruta=transferencia/formulario">Transferir</a>
        <a href="?ruta=transferencia/historial">Transferencias</a>
        <a class="secundario" href="?ruta=autenticacion/salir">Salir</a>
    </nav>
</div>

<div class="tarjeta">
    <h2>Saldo disponible</h2>
    <div class="saldo">$ <?= (number_format((float) $cuenta['saldo'], 2, ',', '.')) ?></div>
</div>
