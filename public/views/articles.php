<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Artyku³y</title>
  <link rel="stylesheet" href="/public/styles/main.css">
  <link rel="stylesheet" href="/public/styles/header.css">
  <link rel="stylesheet" href="/public/styles/articles.css">
  <script defer src="/public/scripts/articles.js"></script>
</head>
<body>
<?php include "header.php"; ?>

<main class="articles">
  <h2>Najnowsze artyku³y</h2>
  <div id="articleGrid" class="article-grid"></div>
  <button id="loadMore" class="load-more">Load more</button>
</main>
</body>
</html>
