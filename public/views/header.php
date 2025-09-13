<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Header - Ski Slopes</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/8fd9367667.js" crossorigin="anonymous"></script>

  <link href="/public/styles/main.css" rel="stylesheet">
  <link href="/public/styles/header.css" rel="stylesheet">
</head>
<body>
<header>
  <div>
    <a class="logo" href="/public/views/index.php">
      <span class="brand-icon">▲</span>
      <span class="brand-text">SKI SLOPES</span>
    </a>
    <nav class="nav">
      <ul class="desktop-icons">
        <li><a href="/public/views/dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
        <li><a href="/public/views/articles.php"><i class="fa-solid fa-newspaper"></i> Articles</a></li>
        <li><a href="/public/views/ranking.php"><i class="fa-solid fa-trophy"></i> Ranking</a></li>

        <?php if (isset($_SESSION["user_id"])): ?>
            <?php if ($_SESSION["role"] === "user"): ?>
              <li><a href="/public/views/settings.php"><i class="fa-solid fa-gear"></i> Moje ustawienia</a></li>
            <?php endif; ?>
            <?php if ($_SESSION["role"] === "admin"): ?>
              <li><a href="/public/views/admin.php"><i class="fa-solid fa-user-gear"></i> Admin</a></li>
            <?php endif; ?>
            <li><a href="/public/views/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Wyloguj</a></li>
        <?php else: ?>
            <li><a href="/public/views/login.php"><i class="fa-solid fa-right-to-bracket"></i> Log in</a></li>
            <li><a href="/public/views/register.php"><i class="fa-solid fa-user-plus"></i> Sign in</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</header>
