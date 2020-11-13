const listaRoles=document.getElementById("area");
const licencia=document.getElementById("licencia");

listaRoles.addEventListener("change",()=>{
    if(listaRoles.value==4){
        const campo="<input class='form-control' type='text' name='tipo_licencia' placeholder='Ingrese su tipo de licencia'>";
        licencia.innerHTML=campo;
    }
    else licencia.innerHTML="";

})