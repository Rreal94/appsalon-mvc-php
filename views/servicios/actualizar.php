<?php include_once __DIR__ . '/../templates/barra.php'; ?>
<h1 class="nombre-pagina">Actualizar Servicio</h1>
<p class="descripcion-pagina">Actualizar informacion de un servicio</p>

<?php
    require_once __DIR__ ."/../templates/alertas.php";
?>

<form method="POST">
    <?php require_once __DIR__ . "/formulario.php"?> 
    <div class="campo">
        <input type="submit" value="Actualizar Servicio" class="boton">
    </div>
</form>

<?php
    $script = "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    
    if(!is_null($exito) && $exito){
        
        $script .= 
        "<script type='text/javascript'>
          Swal.fire({
              title: 'Actualizado!',
              text: 'El servicio ha sido actualizado correctamente.',
              icon: 'success'
          }).then((resultado)=>{
                    if(resultado.isConfirmed){
                        window.location.assign('/servicios');
                    };
                }
            );;
        </script>";
    };
    if(!is_null($exito) && !$exito){
        $script .= 
        "<script type='text/javascript'>
          Swal.fire({
              title: 'Opss!',
              text: 'El servicio no se actualizo, intenta nuevamente.',
              icon: 'error'
          }).then((resultado)=>{
                    if(resultado.isConfirmed){
                        window.location.assign('/servicios');
                    };
                }
            );;
        </script>";
    };
    
?>