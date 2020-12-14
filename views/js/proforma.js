const clientes = document.getElementById("clientes");
const cuit = document.getElementById("cuit");
const editar = document.getElementById("editar");

const datosClientes = () => {
    const cliente = clientes.value;
    const url = document.getElementById("url").value;

    fetch(url + "/cliente/api?cuit=" + cliente)
        .then(res => res.json())
        .then(res => {
            document.getElementById("cuit").innerHTML = res[0].CUIT;
            document.getElementById("denominacion").innerHTML = res[0].denominacion;
            document.getElementById("direccion").innerHTML = res[0].direccion;
            document.getElementById("telefono").innerHTML = res[0].telefono;
            document.getElementById("email").innerHTML = res[0].email;
            document.getElementById("contacto1").innerHTML = res[0].contacto1;
            document.getElementById("contacto2").innerHTML = res[0].contacto2;
        });
}

if (editar)
    datosClientes();

clientes.addEventListener("change", () => {
    datosClientes();
})

const eta = document.getElementById("eta");
const eta_costeo = document.getElementById("eta_costeo");

eta.addEventListener("change", () => {
    eta_costeo.value = eta.value;
})

const tipo_carga = document.getElementById("tipo_carga");

tipo_carga.addEventListener("change", () => {
    if (tipo_carga.value == "Líquida") {
        select_hazard.value = "si";
        select_reefer.value = "si";
    } else if (tipo_carga.value == '40"') {
        select_hazard.value = "0";
        select_reefer.value = "0";

    } else {
        select_hazard.value = "0";
        select_reefer.value = "0";
    }
})


const estimados = document.getElementsByClassName("estimados");
const totales = document.getElementsByClassName("reales");
const total_estimado = document.getElementById("totalEstimado");

for (let valor of estimados) {
    // valor.value=0;
    valor.addEventListener("change", () => {
        let sumaEstimado = 0;
        for (let estimado of estimados) {
            sumaEstimado += parseInt(estimado.value);
        }
        total_estimado.value = sumaEstimado;
    })
}