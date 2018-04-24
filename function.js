
var x = document.getElementById("position"); // Initializing our current position

// Checking the broser compatibility 
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

// take and display the latitude and longitude of a current point 
function showPosition(position) {
    /* 
    x.innerHTML = "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude;
    */
    // Passing latitude and longitude
    window.location.href = "index.php?lat=" + position.coords.latitude +"&lng="+position.coords.longitude; 
}
