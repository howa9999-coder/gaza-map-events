//Nav
const navLinks = document.querySelector(".nav-links");
function onToggleMenu(e) {
  if (e.name === "menu") {
    e.name = "close";
  } else {
    e.name = "menu";
  }
  navLinks.classList.toggle("top-[95%]");
}

// Leaflet Map
const map = L.map("map").setView([31.5, 34.47], 12); // Center on Gaza Strip

// BaseLayer
var googleSat = L.tileLayer(
  "https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}",
  {
    maxZoom: 20,
    attribution:
      'Map data &copy; <a href="https://www.google.com/intl/en_us/help/terms_maps.html">Google</a>',
    subdomains: ["mt0", "mt1", "mt2", "mt3"],
  }
).addTo(map);
var osm = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 19,
  attribution:
    '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
});
var Stadia_AlidadeSmoothDark = L.tileLayer(
  "https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.{ext}",
  {
    minZoom: 0,
    maxZoom: 20,
    attribution:
      '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    ext: "png",
  }
);

//Add scalebar to map
L.control.scale({ metric: true, imperial: false, maxWidth: 100 }).addTo(map);

// Control baseLayers
var baseLayers = {
  "Google Sat": googleSat,
  "Open Street Map": osm,
  SmoothDark: Stadia_AlidadeSmoothDark,
};

var controlLayers = L.control
  .layers(
    baseLayers,
    {},
    {
      collapsed: true,
    }
  )
  .addTo(map);

// Add overlayers & article => page

//RADIO AND ARTICLE
fetch("layer.json")
  .then((response) => response.json())
  .then((data) => {
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
      const {
        name,
        wfsURL,
        color,
        className,
        weight,
        minWidth,
        width,
        maxWidth,
        title,
        article,
        type,
      } = layerData;

      return getWFSgeojson(wfsURL).then((geojsonData) => {
        if (geojsonData) {
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
                  layer.bindPopup(feature.properties.name, {
                    /*    className: className,
                                        minWidth: minWidth,
                                        maxWidth: maxWidth */
                  });
                },
              });
              console.log(type);
              break;
            case "line":
              layer = L.geoJSON(geojsonData, {
                style: function () {
                  return {
                    color: color,
                    weight: weight,
                    //  dashArray: '5, 5' // example for dashed lines
                  };
                },
                onEachFeature: function (feature, layer) {
                  layer.bindPopup(feature.properties.name, {
                    // className: className,
                    // minWidth: minWidth,
                    // maxWidth: maxWidth
                    width: width,
                  });
                },
              });
              console.log(type);
              break;
            case "point":
              layer = L.geoJSON(geojsonData, {
                pointToLayer: function (feature, latlng) {
                  return L.circleMarker(latlng, {
                    radius: 8, // example radius for points
                    fillColor: color,
                    color: "#000",
                    weight: weight,
                    fillOpacity: 0.8,
                  });
                },
                onEachFeature: function (feature, layer) {
                  layer.bindPopup(feature.properties.name, {
                    // className: className,
                    //  minWidth: minWidth,
                    // maxWidth: maxWidth
                  });
                },
              });
              console.log(type);
              break;
            default:
              console.warn("Unknown layer type:", type);
              return; // Skip if the type is not recognized
          }

          // Store the layer in the overLayers object
          overLayers[name] = { layer, title, article };

          // Create a radio button for the custom control
          createLayerRadioButton(name, layer, title, article);
        }
      });
    }

    // Create radio buttons for each layer
    function createLayerRadioButton(name, layer, title, article) {
      const radioContainer = document.createElement("div");
      radioContainer.className = "flex items-center mb-2";

      const radio = document.createElement("input");
      radio.type = "radio";
      radio.name = "layer";
      radio.id = name;
      radio.className = "mr-2";
      radio.onclick = function () {
        if (currentLayer) {
          // Remove the currently selected layer
          map.removeLayer(currentLayer);
        }
        // Add the new layer to the map
        map.addLayer(layer);
        currentLayer = layer;

        // Update title and article content
        document.getElementById("title").innerHTML = title;
        document.getElementById("article").innerHTML = article;
        // Fit the map bounds to the new layer
        const layerBounds = layer.getBounds();
        if (layerBounds.isValid()) {
          map.fitBounds(layerBounds);
        }
      };

      const label = document.createElement("label");
      label.htmlFor = name;
      label.innerText = name;
      label.className = "cursor-pointer";

      // Append radio button & label to container
      radioContainer.appendChild(radio);
      radioContainer.appendChild(label);

      // Append to #radio-Layers
      document.getElementById("radio-Layers").appendChild(radioContainer);
    }

    // Promises for each layer
    var layerPromises = data.map((layerData) => createLayer(layerData));

    // Automatically click the first radio button
    Promise.all(layerPromises).then(() => {
      const firstRadio = document.querySelector('input[name="layer"]');
      if (firstRadio) {
        firstRadio.click();
      }
    });
  });
