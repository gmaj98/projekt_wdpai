<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../models/User.php";

class UserRepository {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function findByEmail(string $email): ?User {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(["email" => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new User($row) : null;
    }

    public function findByUsername(string $username): ?User {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(["username" => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new User($row) : null;
    }

    public function createUser(string $username, string $email, string $passwordHash, string $role = "user"): ?User {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO users (username, email, password_hash, role)
                VALUES (:username, :email, :password_hash, :role)
                RETURNING *
            ");
            $stmt->execute([
                "username"      => $username,
                "email"         => $email,
                "password_hash" => $passwordHash,
                "role"          => $role
            ]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? new User($row) : null;
        } catch (PDOException $e) {
            if ($e->getCode() === "23505") {
                return null;
            }
            throw $e;
        }
    }

    public function verifyPassword(string $emailOrUsername, string $password): ?User {
        $stmt = $this->conn->prepare("
            SELECT * FROM users 
            WHERE email = :login OR username = :login
            LIMIT 1
        ");
        $stmt->execute(["login" => $emailOrUsername]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row["password_hash"])) {
            return new User($row);
        }
        return null;
    }

    public function getAllUsers(): array {
        $stmt = $this->conn->query("SELECT id, username, email, role, created_at FROM users ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(["id" => $id]);
    }
}
