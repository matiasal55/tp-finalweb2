class UserLocation{
    constructor(callback){
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(localizacion=>{
                this.latitude=localizacion.coords.latitude;
                this.longitude=localizacion.coords.longitude;
                var x = document.getElementById("posicion");
                x.value = this.latitude + "," + this.longitude;
                callback();
            })
        }
        else document.write("Tu navegador no soporta Geolocalización")
    }
}

window.addEventListener("load",()=>{
    var platform = new H.service.Platform({
        'apikey': 'yCiUJfZ5REQ1xJgF4UBFTzG-HMoHD16uKKVXxwD9N3k'
    });

    const user_location=new UserLocation(()=>{
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
    },alert)
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