<?php
require_once __DIR__ . "/../config/Database.php";

class RankingRepository {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }


    public function getUserStats(int $userId): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM ranking WHERE user_id = :uid LIMIT 1");
        $stmt->execute(["uid" => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function addActivity(int $userId, float $distance, float $speed): bool {
        $stmt = $this->conn->prepare("SELECT * FROM ranking WHERE user_id = :uid LIMIT 1");
        $stmt->execute(["uid" => $userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $points = intval($distance * 10 + $speed * 5);

        if ($row) {
            $newDistance = $row["distance_km"] + $distance;
            $newSpeed = max($row["max_speed_kmh"], $speed);
            $newPoints = $row["points"] + $points;

            $update = $this->conn->prepare("
                UPDATE ranking 
                SET distance_km = :d, max_speed_kmh = :s, points = :p
                WHERE user_id = :uid
            ");
            return $update->execute([
                "d" => $newDistance,
                "s" => $newSpeed,
                "p" => $newPoints,
                "uid" => $userId
            ]);
        } else {
            $insert = $this->conn->prepare("
                INSERT INTO ranking (user_id, distance_km, max_speed_kmh, points)
                VALUES (:uid, :d, :s, :p)
            ");
            return $insert->execute([
                "uid" => $userId,
                "d"   => $distance,
                "s"   => $speed,
                "p"   => $points
            ]);
        }
    }
}
