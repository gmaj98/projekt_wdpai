<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . "/../config/Database.php";

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    echo json_encode(["error" => "Musisz być zalogowany"]);
    exit;
}

try {
    $db = new Database();
    $pdo = $db->connect();

    $stmt = $pdo->prepare("
        SELECT distance_km AS distance, max_speed_kmh AS speed, points
        FROM ranking
        WHERE user_id = :uid
        LIMIT 1
    ");
    $stmt->execute(["uid" => $_SESSION["user_id"]]);
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "stats" => [
            "user_id"  => $_SESSION["user_id"],
            "distance" => $stats ? (float)$stats["distance"] : 0,
            "speed"    => $stats ? (float)$stats["speed"] : 0,
            "points"   => $stats ? (int)$stats["points"] : 0
        ]
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Błąd serwera: " . $e->getMessage()]);
}
