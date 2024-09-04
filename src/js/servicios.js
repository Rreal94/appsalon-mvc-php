document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});


function iniciarApp(){
    confirmarEliminacion();
}

function confirmarEliminacion(){
    const elementos = document.querySelectorAll('form');

    elementos.forEach(elemento => {
        const btnEliminar = elemento.childNodes[3];

        btnEliminar.addEventListener('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            Swal.fire({
                title: "Estas seguro?",
                text: "No se prodra deshacer esta accion!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!"
              }).then((result) => {
                if (result.isConfirmed) {
                  elemento.submit();
                }
              });
        })
        
    })
}