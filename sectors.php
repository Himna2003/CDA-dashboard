<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Capital Development Authority</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="map.css" />
</head>
<body>

  <div class="sidebar">
    <h2>Dashboard</h2>
    <a href="dashboard.php">Home</a>
    <a href="sectors.php">Sectors</a>
    <a href="zones.php">Zones</a>
    <a href="map.php">Markaz</a>
  </div>

  <div class="main">
    <div class="sector-select-container">
      <label for="sectorSelect">Select Sector:</label>
      <select id="sectorSelect">
        <option value="">-- Select --</option>
      </select>
    </div>

    <div id="areaInfo" style="display:none;">
      <p><strong>Name:</strong> <span id="sectorName"></span></p>
      <p><strong>Location:</strong><span id="sectorLocation"></span></p>
    </div>

    <div id="map"></div>
  </div>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script>
    const select = document.getElementById('sectorSelect');
    const sectorName = document.getElementById('sectorName');
    const sectorLocation = document.getElementById('sectorLocation')
    const areaInfo = document.getElementById('areaInfo');
    const map = L.map('map').setView([33.6844, 73.0479], 7);
    let marker;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18
    }).addTo(map);

   fetch("get_sector.php")
  .then(res => res.json())
  .then(data => {
    data.forEach(row => {
      let option = document.createElement("option");
      option.value = JSON.stringify(row);
      option.textContent = row.name; 
      select.appendChild(option);
    });
  });

select.addEventListener('change', () => {
  if (!select.value) {
    areaInfo.style.display = 'none';
    if (marker) map.removeLayer(marker);
    return;
  }

  const sector = JSON.parse(select.value);

  sectorName.textContent = sector.name || "N/A";
  sectorLocation.textContent = `${sector.latitude || "N/A"}, ${sector.longitude || "N/A"}`;
  areaInfo.style.display = 'block';

  const lat = parseFloat(sector.latitude) || 33.6844;
  const lon = parseFloat(sector.longitude) || 73.0479;

  if (marker) map.removeLayer(marker);
  marker = L.marker([lat, lon]).addTo(map);
  marker.bindPopup(sector.name).openPopup();

  map.setView([lat, lon], 13);
});

</script>
</body>
</html>
