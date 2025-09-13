<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../repositories/UserRepository.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(['status' => 'LOGIN API OK']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$payload  = json_decode(file_get_contents('php://input'), true);
$login    = trim($payload['username'] ?? '');
$password = (string)($payload['password'] ?? '');

if ($login === '' || $password === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Podaj login (email/username) i hasło']);
    exit;
}

try {
    $repo = new UserRepository();
    $user = $repo->verifyPassword($login, $password);

    if (!$user) {
        http_response_code(401);
        echo json_encode(['error' => 'Nieprawidłowy login lub hasło']);
        exit;
    }

    $_SESSION['user_id'] = $user->id;
    $_SESSION['role']    = $user->role;

    echo json_encode([
        'success' => true,
        'user' => [
            'id'       => $user->id,
            'username' => $user->username,
            'email'    => $user->email,
            'role'     => $user->role
        ]
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Błąd serwera', 'details' => $e->getMessage()]);
}
