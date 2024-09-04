<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos.</p>

<?php
    require_once __DIR__ ."/../templates/alertas.php";
?>

<form action="/" class="formulario" method="post">
    <div class="campo-login">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu Email" name="email" autocomplete="email"> 
    </div>
    <div class="campo-login">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu Password" name="password" autocomplete>
    </div>

    <div class="campo-login">
        <input type="submit" class="boton" value="Iniciar Sesion">
    </div>
    
</form>

<div class="acciones">
    <a href="/crear-cuenta">Crear una cuenta</a>
    <a href="/olvide">Olvide mi Password</a>
</div>