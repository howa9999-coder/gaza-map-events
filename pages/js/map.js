
//***************************************************************Interactive Map */
// Leaflet Map
const map = L.map('map').setView([31.5, 34.47], 12); // Center on Gaza Strip

// BaseLayer
    var googleSat = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        attribution: 'Map data &copy; <a href="https://www.google.com/intl/en_us/help/terms_maps.html">Google</a>',
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    }).addTo(map);
    var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });
    var Stadia_AlidadeSmoothDark = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.{ext}', {
        minZoom: 0,
        maxZoom: 20,
        attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        ext: 'png'
    });

//Add scalebar to map
L.control.scale({metric: true, imperial: false, maxWidth: 100}).addTo(map);

// Control baseLayers
var baseLayers = {
    "Google Sat": googleSat,
    "Open Street Map": osm,
    "SmoothDark": Stadia_AlidadeSmoothDark,
  };
  
var controlLayers = L.control.layers(baseLayers, {}, {
    collapsed: true
  }).addTo(map);

// Add overlayers & article => page

// Add overlayers & article => page
fetch('../json/layer.json')
  .then(response => response.json())
  .then(data => {
    var overLayers = {}; 
    var currentLayer = null; 

    async function getWFSgeojson(wfsURL) {
      try {
        const response = await fetch(wfsURL);
        return await response.json();
      } catch (err) {
        console.log(err);
      }
    }




    function createLayer(layerData) {
      const { name, wfsURL, color, className, weight, minWidth, width, maxWidth, title, article, description, type } = layerData;
    

    
      // For polygons, points & lines
      return getWFSgeojson(wfsURL).then(geojsonData => {
        if (geojsonData) {
          let layer;
          switch (type) {
            case 'polygon':
              layer = L.geoJSON(geojsonData, {
                style: function () {
                  return {
                    color: color,
                    weight: weight
                  };
                },
                onEachFeature: function (feature, layer) {
                  layer.bindPopup(feature.properties.name);
                }
              });
              console.log(type);
              break;
            case 'line':
              layer = L.geoJSON(geojsonData, {
                style: function () {
                  return {
                    color: color,
                    weight: weight
                  };
                },
                onEachFeature: function (feature, layer) {
                  layer.bindPopup(feature.properties.name, { width: width });
                }
              });
              console.log(type);
              break;
            case 'point':
              layer = L.geoJSON(geojsonData, {
                pointToLayer: function (feature, latlng) {
                  return L.circleMarker(latlng, {
                    radius: 8, // Example radius for points
                    fillColor: color,
                    color: '#000',
                    weight: weight,
                    fillOpacity: 0.8
                  });
                },
                onEachFeature: function (feature, layer) {
                  layer.bindPopup(feature.properties.name);
                }
              });
              console.log(type);
              break;
            default:
              console.warn('Unknown layer type:', type);
              return; // Skip if the type is not recognized
          }
    
          // Store the layer in the overLayers object
          overLayers[name] = { layer, title, description }; 
    
          // Create an option for the select dropdown
          createLayerOption(name, layer, title, article, description);
        }
      })
    }
    
// Create <option> elements for each layer in the select dropdown
function createLayerOption(name, layer, title, article, description) {
  const select = document.getElementById('layer-select'); // Get the select element

  const option = document.createElement('option');
  option.value = name;
  option.innerText = name;

  // Append the option to the select dropdown
  select.appendChild(option);

  // Add event listener for layer change
  select.addEventListener('change', function (e) {
    const selectedLayerName = e.target.value;
    const selectedLayerData = overLayers[selectedLayerName];

    if (selectedLayerData) {
      if (currentLayer) {
        map.removeLayer(currentLayer);
      }
      const { layer, title, description } = selectedLayerData;
      map.addLayer(layer);
      currentLayer = layer;

      // Update title and description content
      document.getElementById('content').innerHTML =`
        <h3 class="text-xl mt-4 text-white mb-2">${title}</h3>
        <p>${description}</p>
        <button class="read-button text-blue-500 cursor-pointer p-2 bg-transparent" data-title="${title}">
          Read article ...
        </button>
      `;

      // Attach event listeners to all read buttons
      document.querySelectorAll('.read-button').forEach(button => {
        button.addEventListener('click', function() {
          const title = this.getAttribute('data-title');
          localStorage.setItem('title', title);
          window.location.href = "../html/art.html"; 
        });
      });

      // Fit the map bounds to the new layer
      let layerBounds;

      if (layer instanceof L.GeoJSON) {
        layerBounds = layer.getBounds();  // Default bounds for GeoJSON layers (polygons, lines, etc.)
      } else if (layer instanceof L.Marker) {
        layerBounds = layer.getLatLng(); // Use marker's LatLng for fitting map bounds
      } else if (layer instanceof L.LayerGroup) {
        layerBounds = layer.getBounds();  // If the layer is a group of layers (e.g., multiple markers)
      }

      if (layerBounds && layerBounds.isValid()) {
        map.fitBounds(layerBounds);
      } else {
        console.warn("Invalid bounds for layer:", selectedLayerName);
      }
    }
  });
}

// Promises for each layer
var layerPromises = data.map(layerData => createLayer(layerData));

// Automatically select the first layer option
Promise.all(layerPromises).then(() => {
  const firstOption = document.querySelector('#layer-select option');
  if (firstOption) {
    firstOption.selected = true;
    const event = new Event('change');
    document.getElementById('layer-select').dispatchEvent(event);
  }
});


  });

//Full screen
// Get the button and map container elements
const fullScreenButton = document.querySelector('.screen-button');
const mapContainer = document.getElementById('map');

// Function to toggle fullscreen mode
function toggleFullScreen() {
    if (!document.fullscreenElement) {
        if (mapContainer.requestFullscreen) {
            mapContainer.requestFullscreen();
        } else if (mapContainer.mozRequestFullScreen) { // Firefox
            mapContainer.mozRequestFullScreen();
        } else if (mapContainer.webkitRequestFullscreen) { // Chrome, Safari
            mapContainer.webkitRequestFullscreen();
        } else if (mapContainer.msRequestFullscreen) { // IE/Edge
            mapContainer.msRequestFullscreen();
        }
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) { // Firefox
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) { // Chrome, Safari
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) { // IE/Edge
            document.msExitFullscreen();
        }
    }
}

// Add click event to the button
fullScreenButton.addEventListener('click', toggleFullScreen);


//*************************************************************** Event Marker */

const markerMap = L.map('marker-map').setView([31.5, 34.47], 12); // Center on Gaza Strip

// BaseLayer
    var googleSat = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        attribution: 'Map data &copy; <a href="https://www.google.com/intl/en_us/help/terms_maps.html">Google</a>',
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    }).addTo(markerMap);
    var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });
    var Stadia_AlidadeSmoothDark = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.{ext}', {
        minZoom: 0,
        maxZoom: 20,
        attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        ext: 'png'
    });

//Add scalebar to map
L.control.scale({metric: true, imperial: false, maxWidth: 100}).addTo(markerMap);

// Control baseLayers
var baseLayers = {
    "Google Sat": googleSat,
    "Open Street Map": osm,
    "SmoothDark": Stadia_AlidadeSmoothDark,
  };
  
var controlLayers = L.control.layers(baseLayers, {}, {
    collapsed: true
  }).addTo(markerMap);

//add marker layer
    fetch('../json/layer.json')
  .then(response => response.json())
  .then(data => {
    // Create a Layer Group to hold all the markers
    const markerLayerGroup = L.layerGroup();
    
    // Create an array to hold the lat/lng bounds for all markers
    const markerBounds = [];

    // Get the overlay div where we will display the popup content
    const markerCard = document.getElementById("marker-card");

    // Iterate over the data array and create markers for each entry
    data.forEach(i => {
      function createMarkerLayer(markerData) {
        const { name, type, description,title, lat, long, popUp, author, date, category } = markerData;
        if (type === "marker") {
          console.log(10);
          
          // Create the marker
          var marker = L.marker([lat, long])
            .bindPopup(popUp)
            .openPopup();

          // Add the marker to the layer group
          markerLayerGroup.addLayer(marker);

          // Add the marker's lat/lng to the bounds array
          markerBounds.push([lat, long]);

          // When a popup opens, update the overlay content
          marker.on('popupopen', function () {
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
              document.querySelectorAll('.marker-read').forEach(button => {
                button.addEventListener('click', function() {
                    const title = this.getAttribute('data-title');
                    console.log(title)
                    //Store title in local storage
                    localStorage.setItem('title', title);
                    // Redirect to the article page
                    window.location.href = "../html/art.html"; 
  
                });
            });
          });
           
        }
      }

      // Create a marker for each entry
      createMarkerLayer(i);
    });

    // After all markers have been created, add the layer group to the map
    markerLayerGroup.addTo(markerMap);

    // Use fitBounds to adjust the map view to the bounds of all markers
    if (markerBounds.length > 0) {
      const bounds = L.latLngBounds(markerBounds);
      markerMap.fitBounds(bounds);
    }
  })
  .catch(error => {
    console.error('Error loading or parsing the JSON:', error);
  });

  