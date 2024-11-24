$(function () {
  $("#overlay").click(function () {
    $(this).css("transition", "none");
    $(this).fadeOut(600);
  });
});

const map = L.map("map").setView([31.5, 34.47], 12); // Centering map on Gaza Strip

// Add scalebar to map
L.control.scale({ metric: true, imperial: false, maxWidth: 100 }).addTo(map);

// setting & controling baseLayers
var baseLayers = {
  "Google Sat": L.tileLayer(
    "https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}",
    {
      maxZoom: 20,
      attribution:
        'Map data &copy; <a href="https://www.google.com/intl/en_us/help/terms_maps.html">Google</a>',
      subdomains: ["mt0", "mt1", "mt2", "mt3"],
    }
  ).addTo(map),
  "Open Street Map": L.tileLayer(
    "https://tile.openstreetmap.org/{z}/{x}/{y}.png",
    {
      maxZoom: 19,
      attribution:
        '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    }
  ),
  SmoothDark: L.tileLayer(
    "https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.{ext}",
    {
      minZoom: 0,
      maxZoom: 20,
      attribution:
        '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      ext: "png",
    }
  ),
};

var controlLayers = L.control
  .layers(baseLayers, {}, { collapsed: true })
  .addTo(map);

let layer;

const {
  id,
  wfsFile,
  color,
  className,
  weight,
  minWidth,
  width,
  maxWidth,
  type,
} = event.shapes;

// For polygons, points & lines
fetch(`/geo-data/${wfsFile}`)
  .then((geo) => geo.json())
  .then((geojsonData) => {
    switch (type) {
      case "polygon":
        layer = L.geoJSON(geojsonData, {
          style: function () {
            return {
              color: color,
              weight: weight,
            };
          },
          onEachFeature: function (feature, layer) {
            layer.bindPopup(feature.properties.name);
          },
        });
        break;
      case "line":
        layer = L.geoJSON(geojsonData, {
          style: function () {
            return {
              color: color,
              weight: weight,
            };
          },
          onEachFeature: function (feature, layer) {
            layer.bindPopup(feature.properties.name, { width: width });
          },
        });
        break;
      case "point":
        layer = L.geoJSON(geojsonData, {
          pointToLayer: function (feature, latlng) {
            return L.circleMarker(latlng, {
              radius: 8, // Example radius for points
              fillColor: color,
              color: "#000",
              weight: weight,
              fillOpacity: 0.8,
            });
          },
          onEachFeature: function (feature, layer) {
            layer.bindPopup(feature.properties.name);
          },
        });
        break;
      default:
        console.warn("Unknown layer type:", type);
        return; // Skip if the type is not recognized
    }
    map.addLayer(layer);

    let layerBounds;

    if (layer instanceof L.GeoJSON || layer instanceof L.LayerGroup) {
      // Default bounds for GeoJSON layers (polygons, lines, etc.)
      // or If the layer is a group of layers (e.g., multiple markers)
      layerBounds = layer.getBounds();
    } else if (layer instanceof L.Marker) {
      layerBounds = layer.getLatLng(); // Use marker's LatLng for fitting map bounds
    } else {
      console.warn("the layer bounds is not ok");
    }

    if (layerBounds && layerBounds.isValid()) {
      map.fitBounds(layerBounds);
    } else {
      console.warn("Invalid bounds for layer:", layer);
    }
  });

/* ===============  add marker layer  =============== */

// Create a Layer Group to hold all the markers
const markerLayerGroup = L.layerGroup();

// Create an array to hold the lat/lng bounds for all markers
const markerBounds = [];

// Get the overlay div where we will display the popup content
const markerCard = document.getElementById("marker-card");

const { lat, long, popUp } = event.shapes;

if (type === "marker") {
  // Create the marker
  var marker = L.marker([lat, long]).bindPopup(popUp).openPopup();

  // Add the marker to the layer group
  markerLayerGroup.addLayer(marker);

  // Add the marker's lat/lng to the bounds array
  markerBounds.push([lat, long]);
}

// After all markers have been created, add the layer group to the map
markerLayerGroup.addTo(map);

// Use fitBounds to adjust the map view to the bounds of all markers
if (markerBounds.length > 0) {
  const bounds = L.latLngBounds(markerBounds);
  map.fitBounds(bounds);
}

// After all markers have been created, add the layer group to the map
markerLayerGroup.addTo(map);

const fullScreenButton = document.querySelector(".screen-button");
const mapContainer = document.getElementById("mapLayer");

// Function to toggle fullscreen mode
function toggleFullScreen() {
  console.log("first");
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

// Add click event to the button
fullScreenButton.addEventListener("click", toggleFullScreen);
