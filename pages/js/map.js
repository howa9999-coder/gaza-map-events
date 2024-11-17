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

let overLayers = {};
let currentLayer = null;

function createLayer(event) {
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
      let layer;
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
      overLayers[event.id] = layer;
    });
}

events.forEach((event) => {
  createLayer(event);
});

/* ===============  add marker layer  =============== */

// Create a Layer Group to hold all the markers
const markerLayerGroup = L.layerGroup();

// Create an array to hold the lat/lng bounds for all markers
const markerBounds = [];

// Get the overlay div where we will display the popup content
const markerCard = document.getElementById("marker-card");

function createMarkerLayer(event) {
  const { type, lat, title, long, popUp, date } = event;
  const { description, author, category } = event.article;

  if (type === "marker") {
    console.log(10);

    // Create the marker
    var marker = L.marker([lat, long]).bindPopup(popUp).openPopup();

    // Add the marker to the layer group
    markerLayerGroup.addLayer(marker);

    // Add the marker's lat/lng to the bounds array
    markerBounds.push([lat, long]);

    // When a popup opens, update the overlay content
    marker.on("popupopen", function () {
      // Update the floating div content with the marker's popup content
      markerCard.innerHTML = `
        <div class="bg-white shadow-lg w-[200px] md:w-[300px] rounded-lg p-4 relative">
                    <h2 class=" md:text-xl text-black font-semibold">${title}</h2>
                    <p class="text-gray-700 mt-2 ">${description}</p>
                    <div class="mt-4 text-sm hidden md:block text-gray-500">
                        <p>Author: ${author}</p>
                        <p>Date: ${date}</p>
                        <p>Category: ${category}</p>
                    </div>
                    <button class="marker-read absolute bottom-4 right-4 text-blue-500 cursor-pointer p-0 bg-transparent border-none" data-title="${title}">
                        Read
                    </button>
                </div>
        `;

      // Attach event listeners to all read buttons
      document.querySelectorAll(".marker-read").forEach((button) => {
        button.addEventListener("click", function () {
          const title = this.getAttribute("data-title");
          console.log(title);
          //Store title in local storage
          localStorage.setItem("title", title);
          // Redirect to the article page
          window.location.href = "../html/art.html";
        });
      });
    });
  }
}

// Iterate over the data array and create markers for each entry
events.forEach((i) => {
  // Create a marker for each entry
  createMarkerLayer(i);
});

// After all markers have been created, add the layer group to the map
markerLayerGroup.addTo(map);

// Use fitBounds to adjust the map view to the bounds of all markers
if (markerBounds.length > 0) {
  const bounds = L.latLngBounds(markerBounds);
  map.fitBounds(bounds);
}

const select = document.getElementById("layer-select"); // Get the select element

// Add event listener for layer change
select.addEventListener("change", function (e) {
  const selectedLayerId = e.target.value;
  const layer = overLayers[selectedLayerId];
  console.log(overLayers, layer);

  if (layer) {
    if (currentLayer) {
      map.removeLayer(currentLayer);
    }
    map.addLayer(layer);
    currentLayer = layer;

    // Update title and description content
    document.getElementById("content").innerHTML = `
        <h3 class="text-xl mt-4 text-white mb-2">hi there</h3>
        <p>hi there</p>
        <a href="hi there" class="read-button text-blue-500 cursor-pointer p-2 bg-transparent">
          Read article
        </a>
      `;

    // Fit the map bounds to the new layer
    let layerBounds;

    if (layer instanceof L.GeoJSON) {
      layerBounds = layer.getBounds(); // Default bounds for GeoJSON layers (polygons, lines, etc.)
    } else if (layer instanceof L.Marker) {
      layerBounds = layer.getLatLng(); // Use marker's LatLng for fitting map bounds
    } else if (layer instanceof L.LayerGroup) {
      layerBounds = layer.getBounds(); // If the layer is a group of layers (e.g., multiple markers)
    }

    if (layerBounds && layerBounds.isValid()) {
      map.fitBounds(layerBounds);
    } else {
      console.warn("Invalid bounds for layer:", selectedLayerId);
    }
  }
});

// Full screen
const fullScreenButton = document.querySelector(".screen-button");
const mapContainer = document.getElementById("map");

// Function to toggle fullscreen mode
fullScreenButton.addEventListener("click", function () {
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
});
