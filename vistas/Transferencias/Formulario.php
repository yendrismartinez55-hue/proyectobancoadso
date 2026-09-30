<div class="tarjeta">
    <h1>Realizar transferencia</h1>

    <?php if (!empty($error)): ?>
        <div class="alerta"><?= ($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($exito)): ?>
        <div class="exito"><?= ($exito) ?></div>
    <?php endif; ?>

    <form method="post" action="?ruta=transferencia/guardar">
        <label for="numero_cuenta_destino">Número de cuenta destino</label>
        <input
            id="numero_cuenta_destino"
            name="numero_cuenta_destino"
            type="text"
            maxlength="20"
            required
        >

        <label for="valor">Valor a transferir</label>
        <input
            id="valor"
            name="valor"
            type="text"
            inputmode="decimal"
            placeholder="Ejemplo: 100000.00"
            required
        >

        <label for="clave">Confirma tu contraseña</label>
        <input id="clave" name="clave" type="password" required>

        <button class="boton" type="submit">Transferir</button>
        <a class="boton secundario" href="?ruta=cuenta/panel">Cancelar</a>
    </form>
</div>
