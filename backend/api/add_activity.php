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

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data["distance"], $data["speed"])) {
    http_response_code(400);
    echo json_encode(["error" => "Brak wymaganych danych"]);
    exit;
}

$distance = (float)$data["distance"];
$speed    = (float)$data["speed"];

if ($distance <= 0 || $speed <= 0) {
    http_response_code(400);
    echo json_encode(["error" => "Dystans i prędkość muszą być większe od zera"]);
    exit;
}

$userId = $_SESSION["user_id"];
$points = intval($distance * 10 + $speed * 5);

try {
    $db = new Database();
    $conn = $db->connect();

    $stmt = $conn->prepare("SELECT * FROM ranking WHERE user_id = :uid LIMIT 1");
    $stmt->execute(["uid" => $userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $newDistance = $row["distance_km"] + $distance;
        $newSpeed    = max($row["max_speed_kmh"], $speed);
        $newPoints   = $row["points"] + $points;

        $update = $conn->prepare("
            UPDATE ranking 
            SET distance_km = :d, max_speed_kmh = :s, points = :p
            WHERE user_id = :uid
        ");
        $update->execute([
            "d"   => $newDistance,
            "s"   => $newSpeed,
            "p"   => $newPoints,
            "uid" => $userId
        ]);
    } else {
        $insert = $conn->prepare("
            INSERT INTO ranking (user_id, distance_km, max_speed_kmh, points)
            VALUES (:uid, :d, :s, :p)
        ");
        $insert->execute([
            "uid" => $userId,
            "d"   => $distance,
            "s"   => $speed,
            "p"   => $points
        ]);
    }

    echo json_encode(["success" => true, "message" => "Aktywność dodana"]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Błąd serwera: " . $e->getMessage()]);
}
