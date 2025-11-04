
    const sector = document.getElementById('sector');
    const subsector = document.getElementById('subsector');
    const plot = document.getElementById('plot');
    const type = document.getElementById('type');
    const street = document.getElementById('street');
    const corner = document.getElementById('corner');
    const size = document.getElementById('size');
    const latSpan = document.getElementById('lat');
    const lngSpan = document.getElementById('lng');
    const areaInfo = document.getElementById('areaInfo');
    let allPlots = [];
    let marker;

    const map = L.map('map').setView([33.6844, 73.0479], 12);
    const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 30, attribution: '&copy; OpenStreetMap'
    });

    const googleSat = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
      maxZoom: 30, attribution: '&copy; Google Satellite'
    });

    const googleHybrid = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
      maxZoom: 30, attribution: '&copy; Google Hybrid'
    });

    const esriSat = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
      attribution: '&copy; Esri Satellite'
    }).addTo(map);
    


    const plotsLayer = L.tileLayer.wms("http://localhost:8080/geoserver/demo/wms", {
      layers: 'demo:D-12_GCS_11032024', format: 'image/png', transparent: true, opacity: 1.0
    });

    const boundaryLayer = L.tileLayer.wms("http://localhost:8080/geoserver/demo/wms", {
      layers: 'demo:ICT_Boundary', format: 'image/png', transparent: true, opacity: 1.0
    }).addTo(map);

    const ZonesLayer = L.tileLayer.wms("http://localhost:8080/geoserver/demo/wms", {
      layers: 'demo:ICT_Zones', format: 'image/png', transparent: true, opacity: 1.0
    });
    
    const RoadsLayer = L.tileLayer.wms("http://localhost:8080/geoserver/demo/wms", {
      layers: 'demo:Major_Roads', format: 'image/png', transparent: true, opacity: 1.0
    });

    const RailwayLayer = L.tileLayer.wms("http://localhost:8080/geoserver/demo/wms", {
      layers: 'demo:Railway_Line', format: 'image/png', transparent: true, opacity: 1.0
    });

    const WaterBodiesLayer = L.tileLayer.wms("http://localhost:8080/geoserver/demo/wms", {
      layers: 'demo:Water_Bodies', format: 'image/png', transparent: true, opacity: 1.0
    });


    const baseMaps = {
      "OpenStreetMap": osm,
      "Google Satellite": googleSat,
      "Google Hybrid": googleHybrid,
      "Esri Satellite": esriSat
    };

    const overlayMaps = {
      "ICT Boundary": boundaryLayer,
      "Plots": plotsLayer,
      "Zones": ZonesLayer,
      "Roads": RoadsLayer,
      "Railway": RailwayLayer,
      "Water Bodies": WaterBodiesLayer
    };

  L.control.layers(baseMaps, overlayMaps, { collapsed: false }).addTo(map);
  map.on('overlayadd overlayremove', () => attachOpacitySliders());

function attachOpacitySliders() {
  const overlayContainer = document.querySelector('.leaflet-control-layers-overlays');
  if (!overlayContainer) return;
  overlayContainer.querySelectorAll('label').forEach(label => {

    if (label.querySelector('.opacity-slider')) return;
    const slider = document.createElement('input');
    slider.type = 'range';
    slider.min = 0;
    slider.max = 1;
    slider.step = 0.1;
    slider.value = 1;
    slider.classList.add('opacity-slider');

    slider.style.width = '100%';
    slider.style.marginTop = '4px';
    label.appendChild(slider);
    const name = label.textContent.trim();
    const layer = overlayMaps[name];
    if (!layer) return;

    slider.addEventListener('input', (e) => {
      const opacity = parseFloat(e.target.value);
      layer.setOpacity(opacity);
    });
  });
}
attachOpacitySliders();
let identifyActive = false;
    document.getElementById('identifyBtn').onclick = () => {
      identifyActive = !identifyActive;
    };

    map.on('click', function(e) {
      if (identifyActive) {
        L.popup()
          .setLatLng(e.latlng)
          .setContent(`<b>Coordinates:</b><br>${e.latlng.lat.toFixed(5)}, ${e.latlng.lng.toFixed(5)}`)
          .openOn(map);
      }
    });

    let measureActive = false;
    let measurePoints = [];
    let measureLine;

    document.getElementById('measureBtn').onclick = () => {
      measureActive = !measureActive;
      identifyActive = false; 

      if (measureActive) {
        measurePoints = [];
        if (measureLine) map.removeLayer(measureLine);
      } else {
        alert("Measurement mode disabled.");
        if (measureLine) map.removeLayer(measureLine);
      }
    };
    map.on('click', function (e) {
      if (identifyActive) {
        L.popup()
          .setLatLng(e.latlng)
          .setContent(
            `<b>Coordinates:</b><br>${e.latlng.lat.toFixed(5)}, ${e.latlng.lng.toFixed(5)}`
          )
          .openOn(map);
      }
      if (measureActive) {
        measurePoints.push(e.latlng);
        L.marker(e.latlng).addTo(map);

        if (measurePoints.length > 1) {
          if (measureLine) map.removeLayer(measureLine);
          measureLine = L.polyline(measurePoints, { color: "red" }).addTo(map);

          let totalDistance = 0;
          for (let i = 1; i < measurePoints.length; i++) {
            totalDistance += map.distance(measurePoints[i - 1], measurePoints[i]);
          }

          L.popup()
            .setLatLng(e.latlng)
            .setContent(`<b>Total Distance:</b> ${(totalDistance / 1000).toFixed(2)} km`)
            .openOn(map);
        }
      }
    });
    map.on('dblclick', function () {
      if (measureActive) {
        measureActive = false;
        alert("Measurement completed!");
      }
    });

    
document.getElementById('downloadBtn').onclick = () => {
    const image = canvas.toDataURL("image/png");
    const link = document.createElement('a');
    link.href = image;
    link.download = 'map_snapshot.png';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};


    fetch('get_plots.php')
      .then(res => res.json())
      .then(data => {
        allPlots = data;
        const sectors = [...new Set(data.map(r => r.Sector))];
        const subsectors = [...new Set(data.map(r => r.Subsector))];
        const streets = [...new Set(data.map(r => r["Street_No/Road"]))];
        const plots = [...new Set(data.map(r => r.Plot))];
        populateList('sectorList', sectors);
        populateList('subsectorList', subsectors);
        populateList('streetList', streets);
        populateList('plotList', plots);
      });

    function populateList(id, arr) {
      const list = document.getElementById(id);
      arr.forEach(i => {
        const opt = document.createElement('option');
        opt.value = i;
        list.appendChild(opt);
      });
    }

    document.getElementById('searchForm').addEventListener('submit', (e) => {
      e.preventDefault();

      const s = document.getElementById('sectorInput').value.toLowerCase();
      const ss = document.getElementById('subsectorInput').value.toLowerCase();
      const st = document.getElementById('streetInput').value.toLowerCase();
      const p = document.getElementById('plotInput').value.toLowerCase();

      const result = allPlots.find(r =>
        (!s || r.Sector.toLowerCase().includes(s)) &&
        (!ss || r.Subsector.toLowerCase().includes(ss)) &&
        (!st || (r["Street_No/Road"] && r["Street_No/Road"].toLowerCase().includes(st))) &&
        (!p || r.Plot.toString().toLowerCase().includes(p))
      );

      if (!result) return alert("No matching plot found!");

      sector.textContent = result.Sector;
      subsector.textContent = result.Subsector;
      plot.textContent = result.Plot;
      type.textContent = result.Type;
      street.textContent = result["Street_No/Road"];
      corner.textContent = result.Corner_status;
      size.textContent = result.Size;
      latSpan.textContent = result.Latitude;
      lngSpan.textContent = result.Longitude;
      areaInfo.style.display = 'block';

      const lat = parseFloat(result.Latitude);
      const lon = parseFloat(result.Longitude);
      if (!isNaN(lat) && !isNaN(lon)) {
        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lon]).addTo(map);
        marker.bindPopup(`Plot ${result.Plot}`).openPopup();
        map.setView([lat, lon], 16);
      }
});