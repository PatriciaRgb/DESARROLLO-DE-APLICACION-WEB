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
    let calificacion = document.getElementById("calificacion").value;
    let libro = document.getElementById("libro").value;
    let comentario = document.getElementById("comentario").value;

    if (nombre === "") {
        event.preventDefault();
        alert("El nombre es obligatorio");
        return;
    }

    if (correo === "") {
        event.preventDefault();
        alert("El correo es obligatorio");
        return;
    }

    if (calificacion === "" || calificacion < 1 || calificacion > 5) {
        event.preventDefault();
        alert("La calificación debe ser un número entre 1 y 5");
        return;
    }

    if (libro === "") {
        event.preventDefault();
        alert("Debes indicar qué libro estás reseñando");
        return;
    }

    if (comentario === "") {
        event.preventDefault();
        alert("El comentario es obligatorio");
        return;
    }

});