(function () {
    const URL_API = "api/resenas.php";

    const zona      = document.getElementById("zonaTabla");
    const estado    = document.getElementById("estadoLista");
    const filtros   = document.getElementById("filtrosActivos");
    const formulario = document.getElementById("formBusqueda");
    const campoQ    = document.getElementById("q");
    const selOrden  = document.getElementById("orden");
    const selDir    = document.getElementById("dir");
    const botones   = [
        document.getElementById("btnBuscar"),
        document.getElementById("btnLimpiar"),
        document.getElementById("btnActualizar")
    ];

    const NOMBRE_ORDEN = {
        id: "registro", nombre: "nombre", libro: "libro",
        calificacion: "calificación", fecha: "fecha"
    };

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

    // Muestra qué criterios aplicó el servidor y actualiza la dirección de la página
    function mostrarFiltros(f) {
        const partes = [];
        if (f.q !== "") {
            partes.push("búsqueda «" + f.q + "»");
        }
        partes.push("orden por " + (NOMBRE_ORDEN[f.orden] || f.orden)
                    + (f.dir === "asc" ? " (ascendente)" : " (descendente)"));
        filtros.textContent = "Criterios activos: " + partes.join(" · ");

        // La dirección guarda los criterios para que al recargar no se pierdan
        const params = new URLSearchParams();
        if (f.q !== "")        { params.set("q", f.q); }
        if (f.orden !== "id")  { params.set("orden", f.orden); }
        if (f.dir !== "desc")  { params.set("dir", f.dir); }
        const consulta = params.toString();
        history.replaceState(null, "", window.location.pathname + (consulta ? "?" + consulta : ""));
    }

    function existeOpcion(select, valor) {
        return Array.from(select.options).some(function (op) { return op.value === valor; });
    }

    // Al abrir la página: si la dirección trae criterios, se ponen en el formulario.
    // Solo se leen q, orden y dir, y el servidor los valida de todos modos.
    function leerCriteriosIniciales() {
        const url = new URLSearchParams(window.location.search);

        const q = url.get("q");
        if (q !== null) {
            campoQ.value = q.slice(0, 50);
        }
        const orden = url.get("orden");
        if (orden !== null && existeOpcion(selOrden, orden)) {
            selOrden.value = orden;
        }
        const dir = url.get("dir");
        if (dir !== null && existeOpcion(selDir, dir)) {
            selDir.value = dir;
        }
    }

    async function cargarLista() {
        botones.forEach(function (b) { b.disabled = true; });   // evita peticiones repetidas
        mostrarEstado("Cargando reseñas…", "");

        try {
            const consulta = new URLSearchParams({
                q: campoQ.value.trim(),
                orden: selOrden.value,
                dir: selDir.value
            });

            const respuesta = await fetch(URL_API + "?" + consulta.toString(), {
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

            // fetch() no considera error un 400, 403 o 500: se revisa a mano
            if (!respuesta.ok || cuerpo === null || cuerpo.ok !== true) {
                const mensaje = (cuerpo && typeof cuerpo.mensaje === "string")
                    ? cuerpo.mensaje
                    : "No fue posible cargar las reseñas.";
                throw new Error(mensaje);
            }

            zona.replaceChildren();                  // actualización parcial: solo esta zona
            mostrarFiltros(cuerpo.filtros);

            if (cuerpo.datos.length === 0) {
                mostrarEstado(
                    cuerpo.filtros.q !== ""
                        ? "No hay reseñas que coincidan con «" + cuerpo.filtros.q + "»."
                        : "Todavía no hay reseñas registradas.",
                    "mensaje-error"
                );
            } else {
                zona.appendChild(construirTabla(cuerpo.datos, cuerpo.puedeAdministrar === true));
                const hora = new Date().toLocaleTimeString("es-MX");
                mostrarEstado("Se muestran " + cuerpo.total + " reseña(s). Actualizado a las " + hora + ".", "mensaje-exito");
            }

        } catch (error) {
            zona.replaceChildren();
            filtros.textContent = "";

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
            botones.forEach(function (b) { b.disabled = false; });
        }
    }

    formulario.addEventListener("submit", function (evento) {
        evento.preventDefault();
        cargarLista();
    });

    document.getElementById("btnLimpiar").addEventListener("click", function () {
        campoQ.value = "";
        selOrden.value = "id";
        selDir.value = "desc";
        cargarLista();
    });

    document.getElementById("btnActualizar").addEventListener("click", cargarLista);

    leerCriteriosIniciales();
    cargarLista();                                   // carga inicial al abrir la página
})();