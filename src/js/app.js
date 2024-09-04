let paso = 1;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: [],
    total: 0
}

document.addEventListener('DOMContentLoaded',function(){
    iniciarApp();
})

function iniciarApp(){
    mostrarSeccion();
    tabs();
    botonesPaginador();
    paginaSiguiente();
    paginaAnterior();

    consultarAPI();

    nombreCliente();
    seleccionarFecha();
    seleccionarHora();

    mostrarResumen();
}

function mostrarSeccion(){

    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior){
    seccionAnterior.classList.remove('mostrar');
    }

    const seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add('mostrar');

    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }

    const tab = document.querySelector(`[data-paso="${paso}"]`)
    tab.classList.add('actual');
}

function tabs(){
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', function(e){
            paso = parseInt(e.target.dataset.paso);

            validarDatos();
            mostrarSeccion();
            botonesPaginador();
        })
    })
}

function botonesPaginador(){
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1){
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    if(paso === 2){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    if(paso === 3){
        paginaSiguiente.classList.add('ocultar');
        paginaAnterior.classList.remove('ocultar');
        mostrarResumen();
    }
}

function paginaSiguiente(){
    const botonPaginaSiguiente = document.querySelector("#siguiente");
    botonPaginaSiguiente.addEventListener('click', function(){
        paso ++;
        validarDatos();
        mostrarSeccion();
        botonesPaginador();
    })
}

function paginaAnterior(){
    const botonPaginaAnterior = document.querySelector("#anterior");
    botonPaginaAnterior.addEventListener('click', function(){
        paso --;
        mostrarSeccion();
        botonesPaginador();
    })
}

async function consultarAPI(){
    try {
        const url = `${location.origin}/api/servicios`;
        const resultado = await fetch(url);
        const servicios = await resultado.json();

        mostrarServicios(servicios);

    } catch (error) {
        console.log(error)
    }
}

function mostrarServicios(servicios){
    servicios.forEach(servicio => {
        const {id, nombre, precio} = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;
        
        const servicioContenedor = document.createElement('DIV');
        servicioContenedor.classList.add('servicio');
        servicioContenedor.dataset.idServicio = id;

        servicioContenedor.addEventListener('click', function(){
            seleccionarServicio(servicio);
        })

        servicioContenedor.appendChild(nombreServicio);
        servicioContenedor.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioContenedor);


    })
}

function seleccionarServicio(servicio){
    const {id, precio} =servicio;
    const {servicios} = cita;

    const contenedorServicio = document.querySelector(`[data-id-servicio="${id}"]`)

    if(servicios.some(agregado => agregado.id === id)){
        cita.servicios = servicios.filter(agregado => agregado.id != id);
        cita.total = parseFloat(cita.total) - parseFloat(precio);
        contenedorServicio.classList.remove('seleccionado');
    }else{
        cita.servicios = [...servicios, servicio];
        cita.total = parseFloat(cita.total) + parseFloat(precio);
        contenedorServicio.classList.add('seleccionado');
    }
}

function nombreCliente(){
    cita.nombre = document.querySelector('#nombre').value;
    cita.id = document.querySelector('#id').value;
}

function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');

    inputFecha.addEventListener('input', function(e){
        const dia = new Date(e.target.value).getUTCDay();

        if([0].includes(dia)){
            e.target.value = "";
            cita.fecha = "";
            crearAlerta('error','Descansamos los Domingos');
        }else{
            cita.fecha = e.target.value;
        }
    })
}

function seleccionarHora(){
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e){
        const horaCita = e.target.value;
        const hora = horaCita.split(':')['0'];
        const minuto = horaCita.split(':')['1'];
        if(hora < 11 || hora > 18){
            crearAlerta('error','Nuestro horario es de 11:00 a 19:00');
            e.target.value = "";
            cita.hora = "";
        }else{
            if(minuto >= 0 && minuto <= 30){
                const nuevoMinuto = '00';
                cita.hora = `${hora}:${nuevoMinuto}`;
            }else{
                const nuevoMinuto = '30';
                cita.hora = `${hora}:${nuevoMinuto}`;
            }
        }
    })

}

function crearAlerta(tipo, mensaje){
    if(document.querySelector('.alerta')) return;

    const alerta = document.createElement('DIV');
    alerta.classList.add('alerta',tipo);
    alerta.textContent = mensaje;

    document.querySelector('.alertas').appendChild(alerta);    

    setTimeout(() => {
        alerta.remove();
    }, 5000);

}

function validarDatos(){
    if(cita.servicios.length === 0){
        crearAlerta('error','Debes seleccionar al menos un servicio para continuar');
        paso = 1;
    }else if(paso === 1 || paso === 2 ){
        
    }else if(cita.fecha === '' || cita.hora === ''){
        crearAlerta('error','Ingresa Fecha y Hora para poder continuar');
        paso = 2;
    }
}

function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');

    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }


    const { nombre, fecha, hora, servicios, total } = cita;

    const tituloResumen = document.createElement('H3');
    tituloResumen.textContent = 'Resumen de tu Cita';

    resumen.appendChild(tituloResumen);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));

    const opciones = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);


    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora}`;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    servicios.forEach(servicio => {
        const {id, precio, nombre } = servicio;

        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const nombreServicio = document.createElement('P');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>$${precio}</span>`;

        contenedorServicio.appendChild(nombreServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    })

    const contenedorServicio = document.createElement('DIV');
    contenedorServicio.classList.add('contenedor-servicio');

    const nombreServicio = document.createElement('P');
    nombreServicio.textContent = 'Total:';

    const precioServicio = document.createElement('P');
    precioServicio.innerHTML = `<span>$${total}.00</span>`;

    contenedorServicio.appendChild(nombreServicio);
    contenedorServicio.appendChild(precioServicio);

    resumen.appendChild(contenedorServicio);

    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';

    resumen.appendChild(botonReservar);

    botonReservar.onclick = reservarCita;

}

async function reservarCita(){
    const { id, fecha, hora, servicios} = cita;
    const idServicios = servicios.map( servicio => servicio.id);

    const datos =  new FormData();
    datos.append('usuarioid', id);
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('servicios', idServicios);

    try {
        const url = `${location.origin}/api/citas`;

        const respuesta = await fetch(url,{
            method: 'POST',
            body: datos
        })

        const resultado = await respuesta.json();
        if(resultado.resultado){
            Swal.fire({
                icon: "success",
                title: "Cita creada exitosamente!",
                text: "Tu cita ha sido agendada correctamente, te esperamos!",
                allowEscapeKey: false,
                allowOutsideClick: false
            }).then((resultado)=>{
                    if(resultado.isConfirmed){
                        window.location.assign('/servicios');
                    };
                }
            );
            
            

        } else {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Algo salio mal, intenta nuevamente mas tarde!"
            });
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Algo salio mal, intenta nuevamente mas tarde!"
        });
    }

    
}

