<?php
require_once __DIR__ . "/../models/Slope.php";

class SlopeRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAll(): array {
        $stmt = $this->pdo->query("
            SELECT id, name, location, latitude, longitude,
                   level_green, level_blue, level_red, level_black, status
            FROM slopes
            ORDER BY name
        ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => new Slope($row), $rows);
    }
}
