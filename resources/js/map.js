// Leaflet Map
const map = L.map("map").setView([31.5, 34.47], 12); // Center on Gaza Strip

// BaseLayer
var Stadia_AlidadeSmoothDark = L.tileLayer(
  "https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.{ext}",
  {
    minZoom: 0,
    maxZoom: 20,
    attribution:
      '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    ext: "png",
  }
).addTo(map);

// Remove zoom control from the map
map.zoomControl.remove();

const fullScreenButton = document.querySelector(".screen-button");
const mapContainer = document.getElementById("map");

// Function to toggle fullscreen mode
function toggleFullScreen() {
  if (!document.fullscreenElement) {
    if (mapContainer.requestFullscreen) {
      mapContainer.requestFullscreen();
    } else if (mapContainer.mozRequestFullScreen) {
      // Firefox
      mapContainer.mozRequestFullScreen();
    } else if (mapContainer.webkitRequestFullscreen) {
      // Chrome, Safari
      mapContainer.webkitRequestFullscreen();
    } else if (mapContainer.msRequestFullscreen) {
      // IE/Edge
      mapContainer.msRequestFullscreen();
    }
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.mozCancelFullScreen) {
      // Firefox
      document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
      // Chrome, Safari
      document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
      // IE/Edge
      document.msExitFullscreen();
    }
  }
}

fullScreenButton.addEventListener("click", toggleFullScreen);

// Create a marker cluster group
const markers = L.markerClusterGroup();

// Add GeoJSON data to the marker cluster
L.geoJSON(GeoJsonEvents, {
  pointToLayer: function (feature, latlng) {
    // Customize marker appearance here
    return L.marker(latlng, {
      title: feature.properties.title, // Set the title for the marker
    });
  },
  onEachFeature: function (feature, layer) {
    if (feature.properties) {
      let popupContent = "<strong>Feature Properties:</strong><br>";
      for (const [key, value] of Object.entries(feature.properties)) {
        // If the property is the link, create a clickable anchor
        if (key === "link") {
          popupContent += `<strong>Link:</strong> <a href="${value}" >${value}</a><br>`;
        } else {
          popupContent += `<strong>${key}:</strong> ${value}<br>`;
        }
      }
      layer.bindPopup(popupContent);
    }
  },
}).eachLayer((layer) => markers.addLayer(layer));

// Add cluster group to the map
map.addLayer(markers);

// Adjust the map to fit all markers
map.fitBounds(markers.getBounds());
// .catch((error) => console.error("Error loading GeoJSON:", error));

$(function () {
  $("#overlay").click(function () {
    $(this).css("transition", "none");
    $(this).fadeOut(600);
  });
});
