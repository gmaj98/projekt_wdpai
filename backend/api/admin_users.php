<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . "/../repositories/UserRepository.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    http_response_code(403);
    echo json_encode(["success" => false, "error" => "Brak dostępu – tylko administrator"]);
    exit;
}

try {
    $repo = new UserRepository();

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $users = $repo->getAllUsers();
        echo json_encode(["success" => true, "users" => $users], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !isset($data["id"])) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Brak ID użytkownika"]);
            exit;
        }

        $deleted = $repo->deleteUser((int)$data["id"]);
        if ($deleted) {
            echo json_encode(["success" => true, "message" => "✅ Użytkownik został usunięty"]);
        } else {
            http_response_code(500);
            echo json_encode(["success" => false, "error" => "❌ Nie udało się usunąć użytkownika"]);
        }
        exit;
    }

    http_response_code(405);
    echo json_encode(["success" => false, "error" => "Metoda niedozwolona"]);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Błąd serwera: " . $e->getMessage()]);
    exit;
}
