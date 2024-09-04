<h1 class="nombre-pagina">Reestablecer Contraseña</h1>
<p class="descripcion-pagina">Ingresa tu E-mail para reestablecer tu contraseña.</p>

<?php include_once __DIR__ . "/../templates/alertas.php" ?>

<form action="/olvide" class="formulario" method="post">
    <div class="campo-login">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu Email" name="email" autocomplete="email"> 
    </div>

    <div class="campo-login">
        <input type="submit" class="boton" value="Reestablecer Contraseña">
    </div>
    
</form>

<div class="acciones">
    <a href="/">Iniciar Sesion</a>
    <a href="/crear-cuenta">Crear Cuenta</a>
</div>