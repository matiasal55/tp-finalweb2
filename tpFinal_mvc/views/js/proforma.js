const select_hazard=document.getElementById("select_hazard");
const select_reefer=document.getElementById("select_reefer");
const campo_hazard=document.getElementById("campo_hazard");
const campo_reefer=document.getElementById("campo_reefer");

const tipo_carga=document.getElementById("tipo_carga");
const imoClass=document.getElementById("imoClass");
const temperatura=document.getElementById("temperatura");


tipo_carga.addEventListener("change",()=>{
    if(tipo_carga.value=="Líquida"){
        select_hazard.value="si";
        select_reefer.value="si";
        imoClass.disabled=false;
        temperatura.disabled=false;
    }
    else if(tipo_carga.value=='40"'){
        select_hazard.value="0";
        select_reefer.value="0";
        imoClass.disabled=false;
        temperatura.disabled=true;
    }
    else {
        select_hazard.value="0";
        select_reefer.value="0";
        imoClass.disabled=true;
        temperatura.disabled=true;
    }
})

const controles=(selector,campo)=>{
    selector.addEventListener("change",()=>{
        if(selector.value=="no")
            campo.disabled=true;
        else campo.disabled=false;
    })
}

controles(select_hazard,campo_hazard);
controles(select_reefer,campo_reefer);