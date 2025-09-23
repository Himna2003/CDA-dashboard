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
    <div class="zone-select-container">
      <label for="zonesSelect">Select Zone:</label>
      <select id="zonesSelect">
        <option value="">-- Select --</option>
      </select>
    </div>

    <div id="areaInfo" style="display:none;">
      <p><strong>Name:</strong> <span id="zoneName"></span></p>
      <p><strong>Location:</strong> <span id="zoneLocation"></span></p>
    </div>

    <div id="map" style="height:500px;"></div>
  </div>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script>
    const select = document.getElementById('zonesSelect');
    const zoneName = document.getElementById('zoneName');
    const zoneLocation = document.getElementById('zoneLocation');
    const areaInfo = document.getElementById('areaInfo');
    const map = L.map('map').setView([33.6844, 73.0479], 7);
    let marker;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18
    }).addTo(map);

    // Load data from PHP
    fetch("get_zone.php")
      .then(res => res.json())
      .then(data => {
        data.forEach(row => {
          let option = document.createElement("option");
          option.value = JSON.stringify(row); 
          option.textContent = row.title; 
          select.appendChild(option);
        });
      });

    select.addEventListener('change', () => {
      if (!select.value) {
        areaInfo.style.display = 'none';
        if (marker) map.removeLayer(marker);
        return;
      }

      const zone = JSON.parse(select.value);  

      zoneName.textContent = zone.title;
      zoneLocation.textContent = `${zone.latitude || "N/A"}, ${zone.longitude || "N/A"}`;
      areaInfo.style.display = 'block';

      const lat = parseFloat(zone.latitude) || 33.6844;  
      const lon = parseFloat(zone.longitude) || 73.0479;

      if (marker) map.removeLayer(marker);
      marker = L.marker([lat, lon]).addTo(map);
      marker.bindPopup(zone.title).openPopup();
      map.setView([lat, lon], 13);
    });
  </script>
</body>
</html>
