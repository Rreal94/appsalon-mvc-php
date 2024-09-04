<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<h1 class="nombre-pagina">Panel de Administracion</h1>
<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
        </div>
    </form>
</div>

<?php if(count($citas) === 0) : ?>
    <h2>No hay citas agendadas</h2>
<?php endif ?>

<div id="citas-admin">
    <?php 
        foreach($citas as $key => $cita) : 
        if($idCita !== $cita->id) :
        $total = 0; 
    ?>  
    <div class="cita">
        <div class="datos">
            <p>
                <i class="fa fa-hashtag" aria-hidden="true"></i>
                <span><?php echo $cita->id; ?></span>
            </p>
            <p>
                <i class="fa fa-user" aria-hidden="true"></i>
                <span><?php echo $cita->cliente; ?></span>
            </p>
            <p>
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                <span><?php echo $cita->hora; ?></span>
            </p>
        </div>
        <div class="tarjeta ocultar-datos">
        <div class="contacto display-none"> 
            <p>
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span><?php echo $cita->email; ?></span>
            </p>
            <p>
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span><?php echo $cita->telefono; ?></span>
            </p>
        </div>
        <div class="servicios display-none">
            <h3>Servicios</h3>
            <table class="tabla-servicios">
                <thead>
                    <tr><th>Servicio</th><th>Precio</th></tr>
                </thead>
                <tbody>
                    <?php 
                        $idCita = $cita->id; 
                        endif;
                    ?>
                    <tr>
                        <td><?php echo $cita->servicio; ?></td>
                        <td>$<?php echo $cita->precio; ?></td>
                    </tr>
                    <?php
                        $total += $cita->precio;
                        $actual = $cita->id;
                        $proximo = $citas[$key + 1]->id ?? 0;
                        if(esUltimo($actual, $proximo)) :
                            
                    ?>
                </tbody>
                <tfoot>
                    <tr><td>Total</td><td>$<?php echo $total; ?>.00</td></tr>
                </tfoot>    
            </table>
            <form action="/api/citas/eliminar" method="post">
                <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                <input type="submit" value="Eliminar" class="boton-rojo">
            </form>
        </div>
        </div>
    </div>   
    <?php 
        endif;  
        endforeach 
    ?>
</div>

<?php 

    $script = "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                 <script src='build/js/buscador.js'></script> ";     
    if($_GET['eliminado']){
        $script .= 
          "<script type='text/javascript'>
            Swal.fire({
                title: 'Eliminado!',
                text: 'La cita ha sido eliminada correctamente.',
                icon: 'success'
            });
          </script>";
    }
?>