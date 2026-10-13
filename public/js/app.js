document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.getElementById('formulario-filtros');
    if(formulario){
        formulario.addEventListener('submit', async function(e) {
            e.preventDefault();

            let tabla = document.getElementById("tabla");
            let nombre = document.getElementById("nombre").value;
            let estado = document.getElementById("estado").value;
            let fechaDesde = document.getElementById("fecha_desde").value;
            let fechaHasta = document.getElementById("fecha_hasta").value;

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
                        <th></th>
                    </tr>
                `;

                if (datos.length == 0) {
                    tabla.innerHTML += "<tr><td>No hay reservas registradas.</td></tr>";
                } else {
                    datos.forEach(i => {
                        tabla.innerHTML += `
                            <tr>
                                <td>${i.id}</td>
                                <td>${i.nombre_huesped}</td>
                                <td>${i.nombre_alojamiento}</td>
                                <td>${i.fecha_entrada}</td>
                                <td>${i.fecha_salida}</td>
                                <td>${i.estado}</td>
                                <td>
                                    <a href="${RUTA_BASE}/detalle/${i.id}">Ver detalles</a>
                                </td>
                            </tr>
                        `;
                    });
                }
                
            }catch(error){
                console.log("Error :", error);
            }
        });
    }
});