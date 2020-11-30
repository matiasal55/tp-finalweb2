var x = document.getElementById("demo");

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


