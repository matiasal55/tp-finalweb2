const listaRoles=document.getElementById("area");
const adicional=document.getElementById("adicional");

listaRoles.addEventListener("change",()=>{
    let campo="";
    if(listaRoles.value==4){
        campo="<input class='form-control' type='text' value=`${$datos['cuit_taller']}` name='tipo_licencia' placeholder='Ingrese su tipo de licencia'>";
        adicional.innerHTML=campo;
    }
    else if(listaRoles.value=="3"){
        campo="<input class='form-control' type='number' name='cuit_taller' placeholder='Ingrese el CUIT de su taller a cargo'>";
        adicional.innerHTML=campo;
    }
    else {
        adicional.innerHTML = "";
    }
})