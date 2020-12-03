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

// campo_licencia()

listaRoles.addEventListener("change", () => {
    campo_licencia();
})

const formulario = document.getElementById("form");

const datos = async (e, callback) => {
    e.preventDefault()
    const url = document.getElementById("url").value;
    const dni = document.getElementById("dni")
    const email = document.getElementById("email")
    const password=document.getElementById("password")
    const re_password=document.getElementById("re_password")
    const errorPassword = document.getElementById("errorpassword")
    const errordni = document.getElementById("errordni")
    const erroremail = document.getElementById("erroremail")
    await fetch(url + "/usuarios/api?dni=" + dni.value + "&email=" + email.value, {mode: 'no-cors'})
        .then(res => res.json()).then(res => {
            if (res.registro || formulario.checkValidity() === false || password.value!=re_password.value) {
                if (res.dni) {
                    dni.classList.add("is-invalid")
                    dni.classList.remove("is-valid")
                    errordni.innerHTML = "El DNI ya existe"
                } else {
                    dni.classList.add("is-valid")
                    dni.classList.remove("is-invalid")
                }
                if (res.email) {
                    email.classList.add("is-invalid")
                    email.classList.remove("is-valid")
                    erroremail.innerHTML = "El email ya existe"
                } else {
                    email.classList.add("is-valid")
                    email.classList.remove("is-invalid")
                }
                if(password.value!=re_password.value){
                    re_password.classList.add("is-invalid")
                    re_password.classList.remove("is-valid")
                    errorPassword.innerHTML="Las contraseñas ingresadas no coinciden"
                }
                else {
                    re_password.classList.add("is-valid")
                    re_password.classList.remove("is-invalid")
                }
            } else {
                dni.classList.remove("is-invalid")
                email.classList.remove("is-invalid")
                $("#form").submit()
            }
        })
}

const parar = (e) => {
    e.preventDefault();
}

formulario.addEventListener("submit", async (e) => {
    await datos(e, parar);
})