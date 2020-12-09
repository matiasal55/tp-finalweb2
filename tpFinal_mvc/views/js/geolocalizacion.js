var x = document.getElementById("posicion");

function showPosition(position) {
    x.value = position.coords.latitude + "," + position.coords.longitude;
}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.value = "Geolocation is not supported by this browser.";
    }
}

getLocation();

window.addEventListener("load",()=>{
    var platform = new H.service.Platform({
        'apikey': 'yCiUJfZ5REQ1xJgF4UBFTzG-HMoHD16uKKVXxwD9N3k'
    });
    const posicion=document.getElementById("posicion").value;
    const valores=posicion.split(",");
    const latitud=valores[0];
    const longitud=valores[1];

    const mapOptions={
        zoom: 17,
        center: { lat: latitud , lng: longitud }
    }

    const direccion=document.getElementById("direccion")

    var service = platform.getSearchService();
    service.reverseGeocode({
        at: `${mapOptions.center.lat},${mapOptions.center.lng}`
    }, (result) => {
        const datos=result.items[0].address.label
        direccion.value=datos
    });
})

const lista=document.getElementById("concepto");
const combustible=document.getElementById("combustible");

function campo_combustible() {
    if (lista.value == 2) {
        combustible.classList.remove("d-none")
        // Esta apuntando al div. Tiene que apuntar al input
        combustible.required = true;
    } else {
        combustible.classList.add("d-none")
        combustible.required = false;
    }
}

lista.addEventListener("change",()=>{
    campo_combustible();
})