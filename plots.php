<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Capital Development Authority</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="map.css" />
  <style>
    #map { height: 500px; width: 100%; }
    .sidebar { width: 200px; float: left; }
    .main { margin-left: 210px; padding: 10px; }
  </style>
</head>
<body>

  <div class="sidebar">
    <img src="CDALOGO.png" alt="Logo" class="logo">
    <h2 class="dashboard-heading">Dashboard</h2>
    <a href="dashboard.php">Home</a>
    <a href="sectors.php">Sectors</a>
    <a href="zones.php">Zones</a>
    <a href="map.php">Markaz</a>
    <a href="plots.php">Plots</a>
  </div>

  <div class="main">
    <div class="grounds-select-container">
      <label for="groundsSelect">Select Plot:</label>
      <select id="groundsSelect">
        <option value="">-- Select --</option>
      </select>
    </div>

<div id="areaInfo" style="display:none;">
  <p><strong>Sector:</strong> <span id="sector"></span></p>
  <p><strong>Subsector:</strong> <span id="subsector"></span></p>
  <p><strong>Plot:</strong> <span id="plot"></span></p>
  <p><strong>Type:</strong> <span id="type"></span></p>
  <p><strong>Street No/Road:</strong> <span id="street"></span></p>
  <p><strong>Corner Status:</strong> <span id="corner"></span></p>
  <p><strong>Size sq_meters:</strong> <span id="size"></span></p>
  <p><strong>Latitude:</strong> <span id="lat"></span></p>
  <p><strong>Longitude:</strong> <span id="lng"></span></p>
</div>

<div id="map"></div>
  </div>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
const select = document.getElementById('groundsSelect');
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

const map = L.map('map').setView([33.6844, 73.0479], 12);
let marker;

  var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 30,
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  var grounds = L.tileLayer.wms("http://localhost:8080/geoserver/demo/wms", {
    layers: 'demo:playground',
    format: 'image/png',
    transparent: true
  }).addTo(map);

  var streets = L.tileLayer.wms("http://localhost:8080/geoserver/demo/wms", {
    layers: 'demo:streets',
    format: 'image/png',
    transparent: true
  }).addTo(map);
  
  var roads = L.tileLayer.wms("http://localhost:8080/geoserver/demo/wms", {
    layers: 'demo:Roads',
    format: 'image/png',
    transparent: true
  }).addTo(map);
  
  var plotsLayer = L.tileLayer.wms("http://localhost:8080/geoserver/demo/wms", {
    layers: 'demo:D-12_GCS_11032024',
    format: 'image/png',
    transparent: true
  }).addTo(map);

  var baseMaps = { "OpenStreetMap": osm };
  var overlayMaps = {
    "Roads": roads,
    "Streets": streets,
    "Grounds": grounds,
    "Plots": plotsLayer
  };

  L.control.layers(baseMaps, overlayMaps).addTo(map);


fetch('get_plots.php') 
  .then(res => res.json())
  .then(data => {
    data.forEach(row => {
      const option = document.createElement('option');
      option.value = JSON.stringify(row); 
      option.textContent = `Plot ${row.Plot}`;
      select.appendChild(option);
    });
  });

select.addEventListener('change', () => {
  if (!select.value) {
    areaInfo.style.display = 'none';
    if (marker) map.removeLayer(marker);
    return;
  }

  const ground = JSON.parse(select.value);
  sector.textContent = ground.Sector;
  subsector.textContent = ground.Subsector;
  plot.textContent = ground.Plot;
  type.textContent = ground.Type;
  street.textContent = ground["Street_No/Road"];
  corner.textContent = ground.Corner_status;
  size.textContent = ground.Size;
  latSpan.textContent = ground.Latitude;
  lngSpan.textContent = ground.Longitude;

  areaInfo.style.display = 'block';

  const lat = parseFloat(ground.Latitude);
  const lon = parseFloat(ground.Longitude);

  if (!isNaN(lat) && !isNaN(lon)) {
    if (marker) map.removeLayer(marker);
    marker = L.marker([lat, lon]).addTo(map);
    marker.bindPopup(ground.Plot).openPopup();
    map.setView([lat, lon], 15);
  }
});
</script>
</body>
</html>
