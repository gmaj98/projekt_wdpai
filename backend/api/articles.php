<?php
header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../repositories/ArticleRepository.php";

try {
    $db = new Database();
    $pdo = $db->connect();

    $repo = new ArticleRepository($pdo);

    if (isset($_GET['id'])) {
        $article = $repo->findById((int)$_GET['id']);
        echo json_encode($article ? $article->toArray() : ["error" => "Not found"]);
    } else {
        $articles = $repo->getAll();
        echo json_encode(array_map(fn($a) => $a->toArray(), $articles));
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
