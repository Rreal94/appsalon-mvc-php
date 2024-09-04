<h1 class="nombre-pagina">Reestablecer Contraseña</h1>
<p class="descripcion-pagina">Ingresa tu nuevo Password.</p>

<?php include_once __DIR__ . "/../templates/alertas.php" ?>
<?php if($mostrar): ?>
<form action="/recuperar?token=<?php echo s($token); ?>" class="formulario" method="post">
    <div class="campo-login">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu Nuevo Password" name="password"> 
    </div>

    <div class="campo-login">
        <input type="submit" class="boton" value="Actualizar Password">
    </div>
    
</form>
<?php endif; ?>

<div class="acciones">
    <a href="/">Iniciar Sesion</a>
    <a href="/crear-cuenta">Crear Cuenta</a>
</div>