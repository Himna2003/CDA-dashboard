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
    <div class="markaz-select-container">
      <label for="markazSelect">Select Markaz:</label>
      <select id="markazSelect">
        <option value="">-- Select --</option>
      </select>
    </div>

    <div id="areaInfo" style="display:none;">
      <p><strong>Name:</strong> <span id="markazName"></span></p>
      <p><strong>Address:</strong> <span id="markazAddress"></span></p>
      <p><strong>Location:</strong> <span id="markazLocation"></span></p>
    </div>

    <div id="map"></div>
  </div>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script>
    const select = document.getElementById('markazSelect');
    const markazName = document.getElementById('markazName');
    const markazAddress = document.getElementById('markazAddress');
    const markazLocation = document.getElementById('markazLocation');
    const areaInfo = document.getElementById('areaInfo');
    const map = L.map('map').setView([33.6844, 73.0479], 7);
    let marker;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18
    }).addTo(map);

    let markazData = [];

    // Fetch all markaz data once
    fetch('get_markaz.php')
      .then(res => res.json())
      .then(data => {
        markazData = data;
        data.forEach(item => {
          const option = document.createElement('option');
          option.value = item.Name;
          option.textContent = item.Name;
          select.appendChild(option);
        });
      })
      .catch(err => {
        console.error('Error loading markaz list:', err);
        alert('Could not load markaz list');
      });

    // On selection, show details
    select.addEventListener('change', () => {
      const selectedName = select.value;
      if (!selectedName) {
        areaInfo.style.display = 'none';
        if (marker) map.removeLayer(marker);
        return;
      }

      const data = markazData.find(m => m.Name === selectedName);
      if (!data) return;

      markazName.textContent = data.Name;
      markazAddress.textContent = data.Address;
      markazLocation.textContent = `${data.Latitude}, ${data.Longitude}`;
      areaInfo.style.display = 'block';

      const lat = parseFloat(data.Latitude);
      const lon = parseFloat(data.Longitude);

      if (marker) map.removeLayer(marker);
      marker = L.marker([lat, lon]).addTo(map);
      marker.bindPopup(data.Name).openPopup();
      map.setView([lat, lon], 13);
    });
  </script>
</body>
</html>
