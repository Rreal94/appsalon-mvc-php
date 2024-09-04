<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Selecciona tus servicios a continuacion</p>

<div class="app">
    <nav class="tabs">
        <button type="button" data-paso="1" class="actual">Servicios</button>
        <button type="button" data-paso="2">Datos Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>
    <div class="alertas"></div>
    <div id="paso-1" class="seccion mostrar">
        <h2>Servicios</h2>
        <p class="texto-centrado">Elige tus servicios a continuacion</p>
        <div id="servicios" class="listado-servicios">

        </div>
    </div>
    <div id="paso-2" class="seccion">
        <h2>Datos de la cita</h2>
        <p class="texto-centrado">Selecciona fecha y hora para tu cita</p>
        <div class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" value="<?php echo $nombre; ?>" disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha de la cita</label>
                <input type="date" id="fecha" min="<?php echo date('Y-m-d') ?>">
            </div>
            <div class="campo">
                <label for="hora">Hora de la cita</label>
                <input type="time" id="hora" min="10:00" max="20:00" step="1800">
                <input type="hidden" id="id" value="<?php echo $id ?>">
            </div>
        </div>
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="texto-centrado">Verifica la informacion de tu cita</p>
    </div>
    <div class="paginacion">
        <button id="anterior" class="boton">&laquo; Anterior</button>
        <button id="siguiente" class="boton">Siguiente &raquo;</button>

    </div>
</div>

<?php
    $script = "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
               <script src='build/js/app.js'></script>";
?>