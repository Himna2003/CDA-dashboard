<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="dashboard.css" />
  <title>Capital Development Authority</title>
</head>
<body>
  <div class="sidebar" style="background-color: darkgreen;">
    <div class="logo">
      <img src="CDALOGO.png" alt="CDA Logo">
    </div>

    <h2>Dashboard</h2>
    <a href="dashboard.php">Home</a>
    <a href="sectors.php">Sectors</a>
    <a href="zones.php">Zones</a>
    <a href="map.php">Markaz</a>
    <a href="plots.php">Plots</a>
  </div>

  <div class="main">
    <div class="navbar" style="background-color: darkgreen; padding: 15px; text-align:center;">
      <h1 id="typewriter" class="typewriter"></h1>
    </div>
    
    <div class="cards">
      <div class="card">
        <h3>Sectors</h3>
        <h4>Explore Sectors of Islamabad</h4>
        <a href="sectors.php" class="btn">Explore</a>
      </div>

      <div class="card">
        <h3>Zones</h3>
        <h4>Explore Zones of Islamabad</h4>
        <a href="zones.php" class="btn">Explore</a>
      </div>

      <div class="card">
        <h3>Markaz</h3>
        <h4>Explore Markaz of Islamabad</h4>
        <a href="map.php" class="btn">Explore</a>
      </div>
    </div>
  </div>

  <script>
    const text = "Welcome to Capital Development Authority";
    let i = 0;
    const speed = 200; 

    function typeWriter() {
      if (i < text.length) {
        document.getElementById("typewriter").textContent += text.charAt(i);
        i++;
        setTimeout(typeWriter, speed);
      }
    }

    window.onload = typeWriter;
  </script>
</body>
</html>
