<div class="tarjeta">
    <h1>Realizar retiro</h1>

    <?php if (!empty($error)): ?>
        <div class="alerta"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" action="?ruta=retiro/guardar">
        <label for="valor">Valor a retirar</label>
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

        <button class="boton" type="submit">Retirar</button>
        <a class="boton secundario" href="?ruta=cuenta/panel">Cancelar</a>
    </form>
</div>
