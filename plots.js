
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
   
    const baseMaps = {
      "OpenStreetMap": osm,
      "Google Satellite": googleSat,
      "Google Hybrid": googleHybrid,
      "Esri Satellite": esriSat
    };

    const overlayMaps = {
      "Boundary": boundaryLayer,
      "Plots": plotsLayer,
      "Zones": ZonesLayer
    };

    L.control.layers(baseMaps, overlayMaps, { collapsed: false }).addTo(map);

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