const listaRoles=document.getElementById("area");
const adicional=document.getElementById("adicional");
const licencia=document.getElementById("tipo_licencia");

listaRoles.addEventListener("change",()=>{
    if(listaRoles.value==4){
        licencia.classList.remove("d-none")
    }
    else {
        licencia.classList.add("d-none")
    }
})