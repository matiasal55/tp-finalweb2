const listaRoles=document.getElementById("area");
const adicional=document.getElementById("adicional");
const licencia=document.getElementById("tipo_licencia");

function campo_licencia(){
    if(listaRoles.value==4){
        licencia.classList.remove("d-none")
        licencia.required=true;
    }
    else {
        licencia.classList.add("d-none")
        licencia.required=false;
    }
}

campo_licencia()

listaRoles.addEventListener("change",()=>{
    campo_licencia();
})

const password=document.getElementById("password")
const re_password=document.getElementById("re_password")