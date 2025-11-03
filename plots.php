<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Capital Development Authority</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="plots.css" />

</head>
<body>
  <div class="main">
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
  <div id="map-container">
  <div id="map-tools">
    <button id="identifyBtn" title="Identify">🧾</button>
    <button id="measureBtn" title="Measure">📏</button>
    <button id="downloadBtn" title="Download Map">⬇️</button>
  </div>
  <div id="map"></div>
</div>

  </div>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
  <script src="plots.js"></script>
</body>
</html>
