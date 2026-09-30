<div class="tarjeta">
    <h1>Banco ADSO</h1>
    <p>Inicio de sesión</p>

    <?php if (!empty($error)): ?>
        <div class="alerta"><?= ($error) ?></div>
    <?php endif; ?>

    <form method="post" action="?ruta=autenticacion/autenticar">
        <label for="numero_cuenta">Número de cuenta</label>
        <input
            id="numero_cuenta"
            name="numero_cuenta"
            type="text"
            required
            maxlength="20"
            autocomplete="username"
        >

        <label for="clave">Contraseña</label>
        <input
            id="clave"
            name="clave"
            type="password"
            required
            autocomplete="current-password"
        >

        <button class="boton" type="submit">Ingresar</button>
    </form>

    <p><strong>Prueba:</strong> cuenta 1000000001 / contraseña Banco123*</p>
</div>
