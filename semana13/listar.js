(function () {
    const URL_API = "api/resenas.php";
    const zona = document.getElementById("zonaTabla");
    const estado = document.getElementById("estadoLista");
    const boton = document.getElementById("btnActualizar");

    function mostrarEstado(texto, clase) {
        estado.textContent = texto;
        estado.className = clase;
    }

    function celda(texto) {
        const td = document.createElement("td");
        td.textContent = texto;          // texto plano: nunca se interpreta como HTML
        return td;
    }

    function celdaAcciones(id) {
        const td = document.createElement("td");

        const editar = document.createElement("a");
        editar.className = "btn-enlace";
        editar.href = "editar.php?id=" + encodeURIComponent(id);
        editar.textContent = "Editar";
        td.appendChild(editar);
        td.appendChild(document.createTextNode(" "));

        // Eliminar sigue siendo un formulario POST con confirmación
        const form = document.createElement("form");
        form.className = "form-inline";
        form.method = "POST";
        form.action = "eliminar.php";
        form.addEventListener("submit", function (evento) {
            if (!confirm("¿Seguro que quieres eliminar esta reseña?")) {
                evento.preventDefault();
            }
        });

        const oculto = document.createElement("input");
        oculto.type = "hidden";
        oculto.name = "id";
        oculto.value = String(id);

        const btn = document.createElement("button");
        btn.type = "submit";
        btn.className = "btn-eliminar";
        btn.textContent = "Eliminar";

        form.appendChild(oculto);
        form.appendChild(btn);
        td.appendChild(form);
        return td;
    }

    function construirTabla(datos, puedeAdministrar) {
        const tabla = document.createElement("table");

        const encabezado = document.createElement("tr");
        const titulos = ["ID", "Nombre", "Libro", "Calificación", "Comentario", "Fecha"];
        if (puedeAdministrar) {
            titulos.push("Acciones");
        }
        titulos.forEach(function (titulo) {
            const th = document.createElement("th");
            th.textContent = titulo;
            encabezado.appendChild(th);
        });
        tabla.appendChild(encabezado);

        datos.forEach(function (fila) {
            const tr = document.createElement("tr");
            tr.appendChild(celda(String(fila.id)));
            tr.appendChild(celda(fila.nombre));
            tr.appendChild(celda(fila.libro));
            tr.appendChild(celda(String(fila.calificacion)));
            tr.appendChild(celda(fila.comentario));
            tr.appendChild(celda(fila.fecha ? fila.fecha : "—"));
            if (puedeAdministrar) {
                tr.appendChild(celdaAcciones(fila.id));
            }
            tabla.appendChild(tr);
        });

        return tabla;
    }

    async function cargarLista() {
        boton.disabled = true;                       // evita peticiones repetidas
        mostrarEstado("Cargando reseñas…", "");

        try {
            const respuesta = await fetch(URL_API, {
                headers: { "Accept": "application/json" },
                credentials: "same-origin"
            });

            // Sesión caducada: no hay nada que mostrar, hay que volver a entrar
            if (respuesta.status === 401) {
                window.location.href = "login_form.php?m=protegida";
                return;
            }

            // Si el cuerpo no es JSON válido, cuerpo queda en null
            let cuerpo = null;
            try {
                cuerpo = await respuesta.json();
            } catch (errorJson) {
                cuerpo = null;
            }

            // fetch() no considera error un 403 o un 500: se revisa a mano
            if (!respuesta.ok || cuerpo === null || cuerpo.ok !== true) {
                const mensaje = (cuerpo && typeof cuerpo.mensaje === "string")
                    ? cuerpo.mensaje
                    : "No fue posible cargar las reseñas.";
                throw new Error(mensaje);
            }

            zona.replaceChildren();                  // actualización parcial: solo esta zona

            if (cuerpo.datos.length === 0) {
                mostrarEstado("Todavía no hay reseñas registradas.", "mensaje-error");
            } else {
                zona.appendChild(construirTabla(cuerpo.datos, cuerpo.puedeAdministrar === true));
                const hora = new Date().toLocaleTimeString("es-MX");
                mostrarEstado("Se muestran " + cuerpo.total + " reseña(s). Actualizado a las " + hora + ".", "mensaje-exito");
            }

        } catch (error) {
            zona.replaceChildren();

            // Un TypeError de fetch() significa que no hubo comunicación con el servidor
            const sinConexion = (error instanceof TypeError);
            mostrarEstado(
                sinConexion
                    ? "No hay comunicación con el servidor. Revisa tu conexión e inténtalo de nuevo."
                    : error.message,
                "mensaje-error"
            );
            console.error("Fallo al cargar la lista:", error.name);
        } finally {
            boton.disabled = false;
        }
    }

    boton.addEventListener("click", cargarLista);
    cargarLista();                                   // carga inicial al abrir la página
})();