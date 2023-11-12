import $ from "jquery";

import "leaflet/dist/leaflet.css";
import L from "leaflet";
delete L.Icon.Default.prototype._getIconUrl;

L.Icon.Default.mergeOptions({
    iconRetinaUrl: "/images/vendor/leaflet/dist/marker-icon-2x.png",
    iconUrl: "/images/vendor/leaflet/dist/marker-icon.png",
    shadowUrl: "/images/vendor/leaflet/dist/marker-shadow.png",
});

var map = L.map("map").setView([3.57898, 98.635307], 15);
L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 15,
    attribution:
        '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(map);
var popup = L.popup();
var marker = L.marker(L.latLng(3.57898, 98.635307)).addTo(map);
$(document).ready(function () {
    $("#address").on("change", function () {
        var address = $(this).val();
        map.on("click", onMapClick);
        $.get(
            location.protocol +
                "//nominatim.openstreetmap.org/search?format=json&q=" +
                address,
            function (data) {
                const location = data[0];
                map.setView(L.latLng(location.lat, location.lon), 15);
                $("#ll").val(`${location.lat},${location.lon}`);

                // Draw map & marker
                L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
                    maxZoom: 19,
                    attribution:
                        '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                }).addTo(map);
                marker = L.marker(L.latLng(location.lat, location.lon)).addTo(
                    map
                );
            }
        );
    });
});

const onMapClick = (e) => {
    if (typeof marker !== "undefined") map.removeLayer(marker);
    marker = L.marker(e.latlng).addTo(map);
};