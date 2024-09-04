<?php include_once __DIR__ . '/../templates/barra.php'; ?>
<h1 class="nombre-pagina">Crear Servicio</h1>
<p class="descripcion-pagina">Agregar un nuevo servicio</p>

<?php
    require_once __DIR__ ."/../templates/alertas.php";
?>

<form method="post">
    <?php require_once __DIR__ . "/formulario.php"?> 
    <div class="campo">
        <input type="submit" value="Agregar Servicio" class="boton">
    </div>
</form>

<?php
    $script = "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    
    if(!is_null($exito) && $exito){
        
        $script .= 
        "<script type='text/javascript'>
          Swal.fire({
              title: 'Creado!',
              text: 'El servicio ha sido agregado correctamente.',
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
              text: 'El servicio no se agrego, intenta nuevamente.',
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