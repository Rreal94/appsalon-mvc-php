document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});


function iniciarApp(){
    buscarPorFecha();
    mostrarCita();
}

function buscarPorFecha(){
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', function(e){
        const fechaSeleccionada = e.target.value;

        window.location = `?fecha=${fechaSeleccionada}`;
    });
}

function mostrarCita(){
    const citas = document.querySelectorAll('.cita');

    citas.forEach(cita => {
        const tarjeta = cita.childNodes[3];
        const contacto = tarjeta.childNodes[1];
        const servicios = tarjeta.childNodes[3];
        const formulario = servicios.childNodes[5];
        const btnEliminar = formulario.childNodes[5];
        

        tarjeta.addEventListener('click', function(e){
            e.stopPropagation();
        })

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
                  formulario.submit();
                }
              });
        })
        

        cita.addEventListener('click', function(){
            if(tarjeta.classList.contains('ocultar-datos')){
                tarjeta.classList.remove('ocultar-datos');
                tarjeta.classList.add('mostrar-datos');
                contacto.classList.remove('display-none');
                servicios.classList.remove('display-none');
            }else{
                tarjeta.classList.add('ocultar-datos');
                tarjeta.classList.remove('mostrar-datos');
                setTimeout(() => {
                    contacto.classList.add('display-none');
                    servicios.classList.add('display-none'); 
                }, 2000);
            }
        })
        
    })
}