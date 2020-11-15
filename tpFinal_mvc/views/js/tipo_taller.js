const externo=document.getElementById("externo");
const interno=document.getElementById("interno");
const taller=document.getElementById("taller");

externo.addEventListener("change",()=>{
    const campo = "<label for='Nombre de taller'>Nombre del taller:</label><input type='text' class='form-control'>";
    taller.innerHTML = campo;
})

interno.addEventListener("change",()=>{
    taller.innerHTML = "";
})

