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
     <!-- Logo -->
  <img src="CDALOGO.png" alt="Logo" class="logo">
 <!-- Dashboard Heading -->
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

  <div id="areaInfo">
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

    fetch('api.php?action=list')
      .then(res => res.json())
      .then(data => {
        data.forEach(name => {
          const option = document.createElement('option');
          option.value = name;
          option.textContent = name;
          select.appendChild(option);
        });
      })
      .catch(err => {
        console.error('Error loading list:', err);
        alert('Could not load markaz list');
      });

    select.addEventListener('change', () => {
      const name = select.value;
      if (!name) {
        areaInfo.style.display = 'none';
        if (marker) map.removeLayer(marker);
        return;
      }

      fetch('api.php?action=detail&name=' + encodeURIComponent(name))
        .then(res => res.json())
        .then(data => {
          markazName.textContent = data.name;
          markazLocation.textContent = `${data.latitude}, ${data.longitude}`;
          areaInfo.style.display = 'block';

          const lat = parseFloat(data.latitude);
          const lon = parseFloat(data.longitude);

          if (marker) map.removeLayer(marker);
          marker = L.marker([lat, lon]).addTo(map);
          map.setView([lat, lon], 13);
        })
        .catch(err => {
          console.error('Error loading details:', err);
          alert('Could not load markaz details');
        });
    });
  </script>
</body>
</html>
