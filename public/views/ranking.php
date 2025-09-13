<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ranking - Ski Slopes</title>
  <link rel="stylesheet" href="/public/styles/main.css">
  <link rel="stylesheet" href="/public/styles/header.css"> 
  <link rel="stylesheet" href="/public/styles/ranking.css">
</head>
<body>
  <?php include __DIR__ . "/header.php"; ?> 

  <main>
    <h2>⛷️ Ranking 2025</h2>
    <table class="ranking">
      <thead>
        <tr>
          <th>Miejsce</th>
          <th>Użytkownik</th>
          <th>Punkty</th>
          <th>Dystans</th>
          <th>Prędkość max</th>
        </tr>
      </thead>
      <tbody id="rankingTable">
        <tr><td colspan="5">⏳ Ładowanie...</td></tr>
      </tbody>
    </table>
  </main>

  <script src="/public/scripts/ranking.js"></script>
</body>
</html>
