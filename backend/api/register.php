<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . "/../repositories/UserRepository.php";

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        http_response_code(405);
        echo json_encode(["error" => "Niedozwolona metoda"]);
        exit;
    }

    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data || !isset($data["username"], $data["email"], $data["password"])) {
        http_response_code(400);
        echo json_encode(["error" => "Wymagane pola: username, email, password"]);
        exit;
    }

    $username = trim($data["username"]);
    $email = trim($data["email"]);
    $password = $data["password"];

    if (strlen($password) < 6) {
        http_response_code(400);
        echo json_encode(["error" => "Hasło musi mieć min. 6 znaków"]);
        exit;
    }

    $repo = new UserRepository();

    if ($repo->findByEmail($email)) {
        http_response_code(409);
        echo json_encode(["error" => "Email jest już zajęty"]);
        exit;
    }
    if ($repo->findByUsername($username)) {
        http_response_code(409);
        echo json_encode(["error" => "Nazwa użytkownika jest już zajęta"]);
        exit;
    }


    $passwordHash = password_hash($password, PASSWORD_BCRYPT);


    $created = $repo->createUser($username, $email, $passwordHash);


    if (!$created) {
        http_response_code(500);
        echo json_encode([
            "error" => "❌ createUser zwrócił false – użytkownik nie został dodany"
        ]);
        exit;
    }


    if ($created instanceof User) {
        $_SESSION["user_id"] = $created->id;
        $_SESSION["username"] = $created->username;
        $_SESSION["role"] = $created->role;

        echo json_encode([
            "success" => true,
            "message" => "✅ Konto zostało utworzone",
            "user" => [
                "id" => $created->id,
                "username" => $created->username,
                "email" => $created->email,
                "role" => $created->role
            ]
        ]);
        exit;
    }

    // fallback – jeśli repo zwróci np. array
    echo json_encode([
        "success" => true,
        "message" => "✅ Konto zostało utworzone (inne zwrócone dane)",
        "data" => $created
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Błąd serwera: " . $e->getMessage(),
        "trace" => $e->getTraceAsString()
    ]);
}
