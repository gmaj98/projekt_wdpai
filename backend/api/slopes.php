<?php
header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../repositories/SlopeRepository.php";

try {
    $db = new Database();
    $pdo = $db->connect();

    $repo = new SlopeRepository($pdo);
    $slopes = $repo->getAll();

    $data = array_map(fn($s) => $s->toArray(), $slopes);

    echo json_encode($data);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
