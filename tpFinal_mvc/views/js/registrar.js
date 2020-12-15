const listaRoles = document.getElementById("area");
const licencia = document.getElementById("tipo_licencia");

function campo_licencia() {
    if (listaRoles.value == 4) {
        licencia.classList.remove("d-none")
        licencia.required = true;
    } else {
        licencia.classList.add("d-none")
        licencia.required = false;
    }
}
listaRoles.addEventListener("change", () => {
    campo_licencia();
})

campo_licencia();
