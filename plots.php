<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Capital Development Authority</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="map.css" />
</head>
<body>

<div class="main">

  <div class="sidebar">
    <img src="CDALOGO.png" alt="Logo" class="logo">
    <h2 class="dashboard-heading">Dashboard</h2>
    <a href="dashboard.php">Home</a>
    <a href="sectors.php">Sectors</a>
    <a href="zones.php">Zones</a>
    <a href="map.php">Markaz</a>
    <a href="plots.php">Plots</a>
  </div>

  <div class="content">
    
    <div class="search-container">
      <h3>Search Plot</h3>
      <form id="searchForm" class="search-form">
        <div class="form-group">
          <label>Sector:</label>
          <input list="sectorList" id="sectorInput" placeholder="Select or type sector">
          <datalist id="sectorList"></datalist>
        </div>

        <div class="form-group">
          <label>Subsector:</label>
          <input list="subsectorList" id="subsectorInput" placeholder="Select or type subsector">
          <datalist id="subsectorList"></datalist>
        </div>

        <div class="form-group">
          <label>Street No/Road:</label>
          <input list="streetList" id="streetInput" placeholder="Select or type street">
          <datalist id="streetList"></datalist>
        </div>

        <div class="form-group">
          <label>Plot:</label>
          <input list="plotList" id="plotInput" placeholder="Select or type plot">
          <datalist id="plotList"></datalist>
        </div>

        <button type="submit">Search</button>
      </form>
    </div>

    <div id="areaInfo">
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
    
    <div class="map-container">
  
  <div class="opacity-control">
    <h3>Layer Transparency</h3>

    <label>Boundary: <span id="boundaryVal">1.0</span></label>
    <input type="range" id="boundarySlider" min="0" max="1" step="0.1" value="1">

    <label>Zones: <span id="zonesVal">1.0</span></label>
    <input type="range" id="zonesSlider" min="0" max="1" step="0.1" value="1">

    <label>Roads: <span id="roadsVal">1.0</span></label>
    <input type="range" id="roadsSlider" min="0" max="1" step="0.1" value="1">

    <label>Railway: <span id="railVal">1.0</span></label>
    <input type="range" id="railSlider" min="0" max="1" step="0.1" value="1">
  </div>

<div id="map"></div>

</div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="plots.js"></script>
</body>
</html>
