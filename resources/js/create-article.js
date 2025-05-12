let btns = document.querySelectorAll(".status-buttons");
btns.forEach((el) => {
  el.addEventListener("click", function () {
    btns.forEach((btn) => btn.classList.remove("active"));
    this.classList.add("active");
    document.getElementById(el.dataset.target).setAttribute("checked", true);
  });
});
articleImage.addEventListener("change", function (e) {
  const [file] = this.files;
  if (file) {
    articleImagePreview.src = URL.createObjectURL(file);
  }
});

$("#commentStatusLabel").on("click", function () {
  let txt = $(this).data("toggle");
  $(this).data("toggle", $(this).text());
  $(this).text(txt);
});

addEventListener("trix-attachment-add", function (event) {
  if (event.attachment.file) {
    uploadFileAttachment(event.attachment);
  }
});

function uploadFileAttachment(attachment) {
  uploadFile(attachment.file, setProgress, setAttributes);

  function setProgress(progress) {
    attachment.setUploadProgress(progress);
  }

  function setAttributes(attributes) {
    attachment.setAttributes(attributes);
  }
}

function uploadFile(file, progressCallback, successCallback) {
  var key = createStorageKey(file);
  var formData = createFormData(key, file);
  var xhr = new XMLHttpRequest();

  xhr.open("POST", HOST, true);
  xhr.setRequestHeader(
    "X-CSRF-TOKEN",
    $('meta[name="csrf-token"]').attr("content")
  );

  xhr.upload.addEventListener("progress", function (event) {
    var progress = (event.loaded / event.total) * 100;
    progressCallback(progress);
  });

  xhr.addEventListener("load", function (event) {
    if (xhr.status == 200) {
      var attributes = {
        url: xhr.response,
        href: xhr.response + "?content-disposition=attachment",
      };
      successCallback(attributes);
    }
  });

  xhr.send(formData);
}

function createStorageKey(file) {
  var date = new Date();
  var day = date.toISOString().slice(0, 10);
  var name = date.getTime() + "-" + file.name;
  return ["tmp", day, name].join("/");
}

function createFormData(key, file) {
  var data = new FormData();
  data.append("key", key);
  data.append("Content-Type", file.type);
  data.append("file", file);
  return data;
}

let geoLayers = [];

function addGeoItem(
  geoLayer,
  layerGroup,
  optionsalProperties = { note: "", color: "orange" }
) {
  const geoJson = geoLayer.toGeoJSON();
  geoJson.properties = optionsalProperties;

  geoLayer.setStyle({
    color: geoJson.properties.color,
  });

  geoLayer.unbindTooltip();
  if (geoJson?.properties?.note?.trim()) {
    geoLayer
      .bindTooltip(geoJson?.properties?.note?.trim(), {
        permanent: true,
        direction: "center",
        className: "map-label",
      })
      .openTooltip();
    shapes.value = JSON.stringify(geoLayers);
  }

  geoLayers.push(geoJson);

  if (geoLayers.length) {
    mapItemsAlert.classList.add("d-none");
  } else {
    mapItemsAlert.classList.remove("d-none");
  }

  shapes.value = JSON.stringify(geoLayers);

  let content = `
    <div calss="input-group">
      <div class="card-body">
        <div class="mb-2 colros-box text-center">
          <button style="width:25px;height:25px;box-shadow:0px 0 5px 0px #aaa;background:#3388ff;" class="p-0 btn rounded-circle color blue" type="button"></button>
          <button style="width:25px;height:25px;box-shadow:0px 0 5px 0px #aaa;background:#DC143C;" class="p-0 btn rounded-circle color red" type="button"></button>
          <button style="width:25px;height:25px;box-shadow:0px 0 5px 0px #aaa;background:#ffa343;" class="p-0 btn rounded-circle color orange" type="button"></button>
        </div>
        <input type="text" class="form-control" placeholder="shape ${geoLayers.length} notes">
        <button class="btn btn-danger animate-up-1 mt-2 delete-btn" type="button"><i class="fa fa-trash"></i></button>
      </div>
    </div>`;

  let inputGroup = document.createElement("div");
  inputGroup.classList.add("card", "mb-3");

  inputGroup.innerHTML = content;

  mapItems.appendChild(inputGroup);

  const colorButtons = inputGroup.querySelectorAll(".color");
  colorButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      geoJson.properties.color = btn.style.background;
      geoLayer.setStyle({
        color: btn.style.background,
      });
    });
  });

  const input = inputGroup.querySelector("input");
  input.addEventListener("input", () => {
    geoJson.properties.note = input.value;
    geoLayer.unbindTooltip();
    if (input.value.trim()) {
      geoLayer
        .bindTooltip(input.value, {
          permanent: true,
          direction: "center",
          className: "map-label",
        })
        .openTooltip();
      shapes.value = JSON.stringify(geoLayers);
    }
  });
  if (geoJson?.properties?.note?.trim()) {
    input.value = geoJson?.properties?.note?.trim();
  }

  const deleteBtn = inputGroup.querySelector(".delete-btn");
  deleteBtn.addEventListener("click", () => {
    inputGroup.remove();
    geoLayers = geoLayers.find((geoItem) => geoItem.id != geoJson.id) ?? [];
    shapes.value = JSON.stringify(geoLayers);
    layerGroup.removeLayer(geoLayer);
    if (geoLayers.length) {
      mapItemsAlert.classList.add("d-none");
    } else {
      mapItemsAlert.classList.remove("d-none");
    }
  });
}

$(window).ready(function () {
  $("#form").on("submit", function () {
    let arr = [];
    $("#tags-input .tags .tag").each(function () {
      arr.push($(this).text().trim().toLowerCase());
    });
    $("#tags").val(arr.join(","));
  });
  window.shakingTags = [];

  function insertTag(text) {
    $("#tags-input .tags").append(`
          <span contenteditable="true" class="tag badge badge-sm py-1 bg-primary position-relative">${text}</span>
        `);
  }

  function processTags(txt) {
    let arr = $("#tags").val().split(",");
    if (!arr.includes(txt)) {
      insertTag(txt);
      arr.push(txt);
      document.querySelector("#tags").value = arr.join(",");
      document.querySelector("#tags-input .input").value = "";
    } else {
      $("#tags-input .tags .tag").each(function () {
        if (
          $(this).text() == document.querySelector("#tags-input .input").value
        ) {
          $(this).addClass("jump-shake");
          window.shakingTags.push($(this));
        }
      });
      setTimeout(() => {
        window.shakingTags.forEach((el) => {
          $(el).removeClass("jump-shake");
        });
      }, 800);
      document.querySelector("#tags-input .input").value = "";
    }
  }

  $("#tags-input .tags").on("click", function (e) {
    if (e.target !== this) {
      return;
    }
    $("#tags-input .input").focus();
  });

  $("#tags-input .input").on("input", function (e) {
    if (
      e.originalEvent.data == "," ||
      ($("#tags-input .input").val().match(/\n/g) || []).length ||
      ($("#tags-input .input").val().match(/,/g) || []).length
    ) {
      if (e.originalEvent.data == ",") {
        $("#tags-input .input").val(
          $("#tags-input .input").val().replace(/,/g, "")
        );
        processTags($("#tags-input .input").val());
      }
      if (($("#tags-input .input").val().match(/\n/g) || []).length) {
        $("#tags-input .input").val(
          $("#tags-input .input").val().replace(/\n/g, "")
        );
        processTags($("#tags-input .input").val());
      }
      if (($("#tags-input .input").val().match(/,/g) || []).length) {
        $("#tags-input .input")
          .val()
          .split(",")
          .forEach((tag) => {
            processTags(tag);
          });
      }
    }
  });

  $("#tags")
    .val()
    .split(",")
    .forEach(function (tag) {
      insertTag(tag);
    });

  /* =====================  GEO Map  ===================== */
  const map = L.map("map").setView([31.43, 34.4], 11);

  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {}).addTo(
    map
  );

  const drawnItems = new L.FeatureGroup();
  map.addLayer(drawnItems);

  if (shapes.value.length) {
    let val = JSON.parse(shapes.value);
    val.forEach((shape) => {
      console.log(shape.properties);
      const layer = L.geoJSON(shape, {
        style: function (feature) {
          return {
            color: feature.properties?.color || "#3388ff",
          };
        },
      });
      layer.addTo(drawnItems);
      addGeoItem(layer, drawnItems, shape.properties);
    });
  }

  map.on(L.Draw.Event.CREATED, async function (e) {
    const layer = e.layer;

    addGeoItem(layer, drawnItems);

    drawnItems.addLayer(layer);
  });

  const drawControl = new L.Control.Draw({
    edit: {
      featureGroup: drawnItems,
    },
    draw: {
      polygon: true,
      rectangle: true,
      marker: true,
      polyline: false,
      circle: false,
    },
  });

  map.addControl(drawControl);
});
