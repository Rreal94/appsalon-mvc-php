<?php include_once __DIR__ . '/../templates/barra.php'; ?>
<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administracion de los Servicios</p>
<div class="lista-servicios">
    <?php foreach($servicios as $servicio) : ?>
    <div class="servicio">
        <div class="datos">
            <p class="nombre"><?php echo $servicio->nombre ?></p>
            <p class="precio">$ <?php echo $servicio->precio ?></p>
        </div>
        <div class="editar">
            <a href="/servicios/actualizar?id=<?php echo $servicio->id ?>" class="boton">Editar</a>
        </div>
        <div class="eliminar">
            <form action="/servicios/eliminar" method="post" class="eliminar">
                <input type="hidden" name="id" id="id" value="<?php echo $servicio->id ?>">
                <input type="submit" value="Eliminar" class="boton boton-rojo">
            </form>
        </div>
    </div>
    <?php endforeach ?>
</div>


<?php
    $script = "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                 <script src='build/js/servicios.js'></script> "; 
    
    if($_GET['eliminado'] === "1"){
        
        $script .= 
        "<script type='text/javascript'>
          Swal.fire({
              title: 'Eliminado!',
              text: 'El servicio ha sido eliminado correctamente.',
              icon: 'success'
          }).then((resultado)=>{
                    if(resultado.isConfirmed){
                        window.location.assign('/servicios');
                    };
                }
            );;
        </script>";
    };
    
?>