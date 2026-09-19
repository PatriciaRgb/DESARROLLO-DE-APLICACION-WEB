console.log("Bienvenida a El Árbol de Higos");

let autor = "Sylvia Plath";
let calificacion = 5;
let disponible = true;

console.log(autor);
console.log(calificacion);
console.log(disponible);

function mostrarBienvenida() {
    alert("Bienvenida a El Árbol de Higos");
}

document.getElementById("btnSaludar").addEventListener("click", function() {
    alert("Bienvenida a El Árbol de Higos, ¡gracias por visitarnos!");
});

document.getElementById("titulo").addEventListener("click", function() {
    document.getElementById("titulo").textContent = "¡Bienvenida, lectora!";
    document.getElementById("titulo").classList.add("titulo-clickeado");
});

document.getElementById("formularioGET").addEventListener("submit", function(event) {

    let nombre = document.getElementById("nombre").value;
    let correo = document.getElementById("correo").value;
    let calif = document.getElementById("calificacion").value;
    let libro = document.getElementById("libro").value;
    let comentario = document.getElementById("comentario").value;

    let mensaje = document.getElementById("mensajeGET");
    mensaje.textContent = "";
    mensaje.classList.remove("mensaje-error", "mensaje-exito");

    if (nombre === "") {
        event.preventDefault();
        mensaje.textContent = "El nombre es obligatorio";
        mensaje.classList.add("mensaje-error");
        return;
    }

    if (correo === "") {
        event.preventDefault();
        mensaje.textContent = "El correo es obligatorio";
        mensaje.classList.add("mensaje-error");
        return;
    }

    if (calif === "" || calif < 1 || calif > 5) {
        event.preventDefault();
        mensaje.textContent = "La calificación debe ser un número entre 1 y 5";
        mensaje.classList.add("mensaje-error");
        return;
    }

    if (libro === "") {
        event.preventDefault();
        mensaje.textContent = "Debes indicar qué libro estás reseñando";
        mensaje.classList.add("mensaje-error");
        return;
    }

    if (comentario === "") {
        event.preventDefault();
        mensaje.textContent = "El comentario es obligatorio";
        mensaje.classList.add("mensaje-error");
        return;
    }

});

document.getElementById("btnInfo").addEventListener("click", function() {
    let info = document.getElementById("informacion");
    if (info.style.display === "none") {
        info.style.display = "block";
    } else {
        info.style.display = "none";
    }
});