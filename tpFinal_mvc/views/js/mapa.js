window.addEventListener("load",()=>{
    var platform = new H.service.Platform({
        'apikey': 'yCiUJfZ5REQ1xJgF4UBFTzG-HMoHD16uKKVXxwD9N3k'
    });
    var maptypes = platform.createDefaultLayers();
    const posicion=document.getElementById("posicion").value;
    const valores=posicion.split(",");
    const latitud=valores[0];
    const longitud=valores[1];

    const mapOptions={
        zoom: 17,
        center: { lat: latitud , lng: longitud }
    }
    const mapaElement=document.getElementById("mapContainer");
    const map=new H.Map(mapaElement,maptypes.vector.normal.map,mapOptions)
    const mapEvents = new H.mapevents.MapEvents(map);
    const ui = H.ui.UI.createDefault(map, maptypes, 'es-ES');

    var marker = new H.map.Marker({lat: latitud, lng: longitud});

    map.addObject(marker);

    const locacion=document.getElementById("locacion")

    var service = platform.getSearchService();
    service.reverseGeocode({
        at: `${mapOptions.center.lat},${mapOptions.center.lng}`
    }, (result) => {
        const datos=result.items[0].address.label
        locacion.innerHTML=datos
    });

})