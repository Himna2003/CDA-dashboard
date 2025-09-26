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
  </div>

  <div class="main">
    <div class="markaz-select-container">
      <label for="markazSelect">Select Markaz:</label>
      <select id="markazSelect">
        <option value="">-- Select --</option>
      </select>
    </div>

    <div id="areaInfo" style="display:none;">
      <p><strong>Name:</strong> <span id="markazName"></span></p>
      <p><strong>Location:</strong> <span id="markazLocation"></span></p>
    </div>

    <div id="map"></div>
  </div>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script>
    const select = document.getElementById('markazSelect');
    const markazName = document.getElementById('markazName');
    const markazLocation = document.getElementById('markazLocation');
    const areaInfo = document.getElementById('areaInfo');
    const map = L.map('map').setView([33.6844, 73.0479], 7);
    let marker;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18
    }).addTo(map);


    fetch('get_markaz.php') 
      .then(res => res.json())
      .then(data => {
        data.forEach(row => {
          const option = document.createElement('option');
          option.value = JSON.stringify(row); 
          option.textContent = row.Name;
          select.appendChild(option);
        });
      })
      .catch(err => {
        console.error('Error loading markaz list:', err);
        alert('Could not load markaz list');
      });

    
    select.addEventListener('change', () => {
      if (!select.value) {
        areaInfo.style.display = 'none';
        if (marker) map.removeLayer(marker);
        return;
      }

      const markaz = JSON.parse(select.value);

      markazName.textContent = markaz.Name;
      markazLocation.textContent = `${markaz.Latitude}, ${markaz.Longitude}`;
      areaInfo.style.display = 'block';

      const lat = parseFloat(markaz.Latitude);
      const lon = parseFloat(markaz.Longitude);

      if (marker) map.removeLayer(marker);
      marker = L.marker([lat, lon]).addTo(map);
      marker.bindPopup(markaz.Name).openPopup();
      map.setView([lat, lon], 13);
    });
  </script>
</body>
</html>
