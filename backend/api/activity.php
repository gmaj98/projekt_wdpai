<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/../config/Database.php";

if (!isset($_SESSION["user_id"])) {
    http_response_code(403);
    echo json_encode(["error" => "Nie jesteś zalogowany"]);
    exit;
}

$db = new Database();
$conn = $db->connect();
$userId = $_SESSION["user_id"];

$stmt = $conn->prepare("SELECT distance_km, max_speed_kmh, points 
                        FROM ranking WHERE user_id = :uid LIMIT 1");
$stmt->execute(["uid" => $userId]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode([
        "success" => true,
        "stats" => [
            "user_id"  => $userId,
            "distance" => (float)$row["distance_km"],
            "speed"    => (float)$row["max_speed_kmh"],
            "points"   => (int)$row["points"]
        ]
    ], JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode([
        "success" => true,
        "stats" => [
            "user_id"  => $userId,
            "distance" => 0,
            "speed"    => 0,
            "points"   => 0
        ]
    ], JSON_UNESCAPED_UNICODE);
}
