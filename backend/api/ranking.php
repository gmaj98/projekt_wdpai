<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/../config/Database.php";

try {
    $db = new Database();
    $conn = $db->connect();

    $stmt = $conn->query("
        SELECT u.username, r.points, r.distance_km, r.max_speed_kmh
        FROM ranking r
        JOIN users u ON r.user_id = u.id
        ORDER BY r.points DESC
        LIMIT 5
    ");

    $ranking = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($ranking, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "B³¹d serwera: " . $e->getMessage()]);
}
