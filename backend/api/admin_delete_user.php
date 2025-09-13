<?php
header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . "/../config/Database.php";

session_start();

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    http_response_code(403);
    echo json_encode(["error" => "Brak dostępu"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["id"])) {
    http_response_code(400);
    echo json_encode(["error" => "Brak ID użytkownika"]);
    exit;
}

try {
    $db = new Database();
    $conn = $db->connect();

    $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(["id" => $data["id"]]);

    echo json_encode(["success" => true, "message" => "✅ Użytkownik został usunięty"]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Błąd serwera", "details" => $e->getMessage()]);
}
