document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.getElementById('formulario-filtros');

    if (formulario) {
        formulario.addEventListener('submit', async function (e) {
            e.preventDefault();

            let tabla = document.getElementById("tabla");
            let nombre = document.getElementById("nombre").value;
            let estado = document.getElementById("estado").value;
            let fechaDesde = document.getElementById("fecha_desde").value;
            let fechaHasta = document.getElementById("fecha_hasta").value;

            tabla.innerHTML = "<tr><td colspan='8'>Cargando reservas...</td></tr>";

            let urlApi = RUTA_BASE + '/reservas?nombre=' + nombre + '&estado=' + estado + '&fecha_desde=' + fechaDesde + '&fecha_hasta=' + fechaHasta;

            try {
                let respuesta = await fetch(urlApi);
                let datos = await respuesta.json();

                tabla.innerHTML = `
                    <tr>
                        <th>ID</th>
                        <th>Huésped</th>
                        <th>Alojamiento</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Estado</th>
                        <th>Importe</th>
                        <th></th>
                    </tr>
                `;

                if (datos.length == 0) {
                    tabla.innerHTML += "<tr><td>No hay reservas registradas.</td></tr>";
                } else {
                    datos.forEach(i => {
                        let importe = parseFloat(i.importe).toFixed(2).replace('.', ',');
                        let entradaFormateada = i.fecha_entrada.split('-').reverse().join('/');
                        let salidaFormateada = i.fecha_salida.split('-').reverse().join('/');

                        let botonesAccion = `<a href="${RUTA_BASE}/detalle/${i.id}">Ver detalles</a>`;

                        if (i.estado !== 'cancelada') {
                            if (i.estado !== 'confirmada') {
                                botonesAccion += ` <button class="btn-confirmar" data-id="${i.id}">Confirmar</button>`;
                            }
                            botonesAccion += ` <button class="btn-cancelar" data-id="${i.id}">Cancelar</button>`;
                        }

                        tabla.innerHTML += `
                            <tr>
                                <td>${i.id}</td>
                                <td>${i.nombre_huesped}</td>
                                <td>${i.nombre_alojamiento}</td>
                                <td>${entradaFormateada}</td>
                                <td>${salidaFormateada}</td>
                                <td>${i.estado}</td>
                                <td>${importe} €</td>
                                <td>${botonesAccion}</td>
                            </tr>
                        `;
                    });

                    activarBotonesEstado();
                }

            } catch (error) {
                console.log("Error :", error);
            }
        });
    }

    const formCrear = document.getElementById('formulario-crear');
    if (formCrear) {
        formCrear.addEventListener('submit', async function (e) {
            e.preventDefault();

            let nombre = document.getElementById("crear_nombre").value;
            let email = document.getElementById("crear_email").value;
            let alojamiento = document.getElementById("crear_alojamiento").value;
            let entrada = document.getElementById("crear_entrada").value;
            let salida = document.getElementById("crear_salida").value;
            let importe = document.getElementById("crear_importe").value;
            let notas = document.getElementById("crear_notas").value;
            let mensajeHTML = document.getElementById("mensaje-crear");

            let nuevaReserva = {
                nombre_huesped: nombre,
                email_huesped: email,
                nombre_alojamiento: alojamiento,
                fecha_entrada: entrada,
                fecha_salida: salida,
                importe: importe,
                notas: notas
            };

            mensajeHTML.textContent = "Guardando reserva, por favor espera...";

            try {
                let respuesta = await fetch(RUTA_BASE + '/reservas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(nuevaReserva)
                });

                let datos = await respuesta.json();

                if (respuesta.status == 201) {
                    mensajeHTML.textContent = "¡Reserva guardada con éxito!";
                    mensajeHTML.style.color = "green";
                    formCrear.reset();

                    let botonFiltrar = document.querySelector("#formulario-filtros button");
                    if (botonFiltrar) {
                        botonFiltrar.click();
                    }
                } else {
                    mensajeHTML.textContent = "Error: " + datos.error;
                    mensajeHTML.style.color = "red";
                }
            } catch (error) {
                console.log("Error de conexión:", error);
            }
        });
    }


    function activarBotonesEstado() {
        let botonesCancelar = document.querySelectorAll(".btn-cancelar");
        
        botonesCancelar.forEach(boton => {
            boton.addEventListener("click", async function() {
                let idReserva = boton.getAttribute("data-id");
                let confirmar = confirm("¿Seguro que quieres cancelar la reserva #" + idReserva + "?");
                
                if (confirmar) {
                    boton.textContent = "Cancelando...";
                    boton.disabled = true;

                    try {
                        let respuesta = await fetch(RUTA_BASE + '/reservas/' + idReserva, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ estado: "cancelada" }) 
                        });

                        if (respuesta.status == 200) {
                            alert("Reserva cancelada con éxito");
                            
                            let botonFiltrar = document.querySelector("#formulario-filtros button");
                            if (botonFiltrar) {
                                botonFiltrar.click();
                            }
                        } else {
                            alert("Error al cancelar la reserva");
                        }
                    } catch(error) {
                        console.log("Error de conexión:", error);
                    }
                }
            });
        });


        let botonesConfirmar = document.querySelectorAll(".btn-confirmar");
        botonesConfirmar.forEach(boton => {
            boton.addEventListener("click", async function() {
                let idReserva = boton.getAttribute("data-id");
                let confirmar = confirm("¿Seguro que quieres confirmar la reserva #" + idReserva + "?");
                
                if (confirmar) {
                    boton.textContent = "Confirmando...";
                    boton.disabled = true;
                    try {
                        let respuesta = await fetch(RUTA_BASE + '/reservas/' + idReserva, {
                            method: 'PUT',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ estado: "confirmada" })
                        });

                        if (respuesta.status == 200) {
                            alert("Reserva confirmada con éxito");
                            let botonFiltrar = document.querySelector("#formulario-filtros button");
                            if (botonFiltrar) botonFiltrar.click();
                        } else {
                            alert("Error al confirmar la reserva");
                        }
                    } catch(error) { console.log("Error:", error); }
                }
            });
        });
    }

    activarBotonesEstado();
});