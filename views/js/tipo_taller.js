const externo=document.getElementById("externo");
const interno=document.getElementById("interno");
const taller=document.getElementById("taller");

externo.addEventListener("change",()=>{
    taller.readOnly=false;
})

interno.addEventListener("change",()=>{
    taller.readOnly=true;
})

