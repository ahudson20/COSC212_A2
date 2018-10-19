var Map = (function () {
    "use strict";
    var pub = {};
    var map, hotel, activities, restaurants, obs, cin, pool, fr, sr, tr;

    /**
     * re-loads the map to fit the changed window size.
     */
    function reSize() {
        map.invalidateSize();
    }

    /**
     * If the map is currently not visible, it shows the map while hiding
     * the other two divs also in index.php.
     * It then calls reSize, which forces the map to re-size according to #map div its displayed in.
     *
     * Otherwise, it shows the search for rooms form, hides the other two divs, and chenges the text
     * in the nav link #showHide to "Find Us" instead of "Book Now".
     */
    function showHide() {
        if ($("#map").css("display") === "none") {
            $("#available").hide();
            $("#map").show(500);
            $("#other").hide(500);
            setTimeout(reSize, 450);
            $("#showHide").text("Book Now");
        } else {
            $("#available").hide();
            $("#map").hide(500);
            $("#other").show(500);
            $("#showHide").text("Find Us");
        }
    }

    /**
     * Setup function for Map.
     * Creates the map, centered around 4 smith street
     * It also creates three activity and three restaurant markers located near the hotel,
     * and adds them to the map layergroup, making them toggle-able.
     *
     * It also sets up the onclick function for the "Find Us/Book Now" link in the navigation.
     */
    pub.setup = function () {

        map = L.map('map').setView([-45.872199, 170.501038], 15);
        map.scrollWheelZoom.disable();
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {maxZoom: 18, attribution: 'Map data &copy; ' + '<a href="http://www.openstreetmap.org/copyright">' +
                    'OpenStreetMap contributors</a> CC-BY-SA'}).addTo(map);

        hotel = L.marker([-45.872162, 170.501001]).addTo(map);
        hotel.bindPopup("<p class='pop-up-title'>Hotel Galley</p>" + "<p class='pop-up-content'>We are located at 4 Smith Street, Dunedin Central, Dunedin, 9016</p>");

        obs = L.marker([-45.872591, 170.492406]).bindPopup("<p class='pop-up-title'>Observatory</p>" + "<p class='pop-up-content'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse a elit vitae felis blandit venenatis. Aliquam pharetra ex sit amet ultricies iaculis. Duis eget lacinia nulla, eu malesuada risus.</p>");
        cin = L.marker([-45.874183, 170.502721]).bindPopup("<p class='pop-up-title'>Reading Cinema</p>" + "<p class='pop-up-content'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse a elit vitae felis blandit venenatis. Aliquam pharetra ex sit amet ultricies iaculis. Duis eget lacinia nulla, eu malesuada risus.</p>");
        pool = L.marker([-45.869881, 170.498816]).bindPopup("<p class='pop-up-title'>Moana Pool</p>" + "<p class='pop-up-content'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse a elit vitae felis blandit venenatis. Aliquam pharetra ex sit amet ultricies iaculis. Duis eget lacinia nulla, eu malesuada risus.</p>");

        activities = L.layerGroup([obs, cin, pool]);

        fr = L.marker([-45.876885, 170.500263]).bindPopup("<p class='pop-up-title'>Speights Ale House</p>" + "<p class='pop-up-content'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse a elit vitae felis blandit venenatis. Aliquam pharetra ex sit amet ultricies iaculis. Duis eget lacinia nulla, eu malesuada risus.</p>");
        sr = L.marker([-45.879691, 170.503015]).bindPopup("<p class='pop-up-title'>Vogel Street Kitchen</p>" + "<p class='pop-up-content'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse a elit vitae felis blandit venenatis. Aliquam pharetra ex sit amet ultricies iaculis. Duis eget lacinia nulla, eu malesuada risus.</p>");
        tr = L.marker([-45.874433, 170.502927]).bindPopup("<p class='pop-up-title'>Nova Cafe</p>" + "<p class='pop-up-content'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse a elit vitae felis blandit venenatis. Aliquam pharetra ex sit amet ultricies iaculis. Duis eget lacinia nulla, eu malesuada risus.</p>");

        restaurants = L.layerGroup([fr, sr, tr]);

        var overlayMaps = {
            "Activities": activities,
            "Restaurants": restaurants
        };

        L.control.layers(null, overlayMaps).addTo(map);

        $("#showHide").click(showHide);
    };
    return pub;
}());

$(document).ready(Map.setup);
