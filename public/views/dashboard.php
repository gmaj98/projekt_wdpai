<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php
require_once __DIR__ . "/../../backend/config/Database.php"; 
$db  = new Database();
$pdo = $db->connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>DASHBOARD</title>
  <link rel="stylesheet" href="/public/styles/main.css" />
  <link rel="stylesheet" href="/public/styles/dashboard.css" />
  <script defer src="/public/scripts/script.js"></script>
</head>
<body>

<?php include __DIR__ . "/header.php"; ?>

<div class="search">
  <div class="filters">
    <div class="filter-box search-box">
      <i class="fas fa-search"></i>
      <input type="text" id="searchInput" placeholder="SEARCH" />
    </div>

    <div class="filter-box">
      <span>LEVELS:</span>
      <span class="dot green" data-level="green"  title="green"></span>
      <span class="dot blue"  data-level="blue"   title="blue"></span>
      <span class="dot red"   data-level="red"    title="red"></span>
      <span class="dot black" data-level="black"  title="black"></span>
    </div>

    <div class="filter-box">
      <span>STATUS:</span>
      <span class="dot green" data-status="open"   title="open"></span>
      <span class="dot red"   data-status="closed" title="closed"></span>
    </div>
  </div>
</div>

<main class="content">
  <aside class="sidebar">
  <ul class="menu" id="slopeList">
  </ul>
</aside>

  <section class="map">
    <iframe
      width="100%" height="100%" frameborder="0" scrolling="no"
      src="https://www.openstreetmap.org/export/embed.html?bbox=19.5,49.5,20.5,50.5&layer">
    </iframe>
  </section>
</main>

</body>
</html>
