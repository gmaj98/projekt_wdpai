<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php
$id = $_GET['id'] ?? null;
if (!$id) {
    die("❌ Brak ID artykułu");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Szczegóły artykułu</title>
  <link rel="stylesheet" href="/public/styles/main.css">
  <link rel="stylesheet" href="/public/styles/header.css">
  <link rel="stylesheet" href="/public/styles/article.css">
  <script defer src="/public/scripts/article.js"></script>
</head>
<body>
<?php include "header.php"; ?>

<main class="article-detail">
  <article>
    <img id="articleImage" src="" alt="">
    <h1 id="articleTitle"></h1>
    <p class="meta">
      <span id="articleAuthor"></span> | 
      <span id="articleDate"></span>
    </p>
    <div id="articleContent"></div>
  </article>

  <a href="/public/views/articles.php" class="back-link">← Powrót do artykułów</a>
</main>

<script>
  const ARTICLE_ID = <?= (int)$id ?>;
</script>
</body>
</html>
