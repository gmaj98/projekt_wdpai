<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <title>Moje ustawienia - Ski Slopes</title>
  <link rel="stylesheet" href="/public/styles/main.css" />
  <link rel="stylesheet" href="/public/styles/header.css" />
  <link rel="stylesheet" href="/public/styles/settings.css" />
  <script defer src="/public/scripts/setting.js"></script>
</head>
<body>
  <?php include __DIR__ . "/header.php"; ?>

  
  <div id="settings-page">
    <main>
      <h2>⚙️ Moje ustawienia</h2>

      <section class="user-stats">
        <h3>Moje statystyki</h3>
        <p><strong>ID użytkownika:</strong> <span id="statUserId"><?php echo $_SESSION["user_id"]; ?></span></p>
        <p><strong>Dystans:</strong> <span id="statDistance">-</span></p>
        <p><strong>Maks. prędkość:</strong> <span id="statSpeed">-</span></p>
        <p><strong>Punkty:</strong> <span id="statPoints">-</span></p>
      </section>


      <section class="user-add-activity">
        <h3>➕ Dodaj aktywność</h3>
        <form id="activityForm">
          <label>Dystans (km):
            <input type="number" step="0.01" id="inputDistance" required />
          </label>
          <label>Prędkość (km/h):
            <input type="number" step="0.01" id="inputSpeed" required />
          </label>
          <button type="submit">Dodaj</button>
        </form>
        <p id="activityMsg"></p>
      </section>
    </main>
  </div>

</body>
</html>
