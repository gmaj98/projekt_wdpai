<?php
require_once __DIR__ . "/../repositories/UserRepository.php";

$repo = new UserRepository();
$user = $repo->createUser("testuser", "test@example.com", "test123");

if ($user) {
    echo "✅ Użytkownik dodany: " . $user->username;
} else {
    echo "❌ Nie udało się dodać użytkownika";
}
