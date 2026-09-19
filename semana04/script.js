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