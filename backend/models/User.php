<?php
class User {
    public int $id;
    public string $username;
    public string $email;
    public string $role;
    public string $created_at;

    public function __construct(array $row) {
        $this->id         = (int)($row["id"] ?? 0);
        $this->username   = (string)($row["username"] ?? "");
        $this->email      = (string)($row["email"] ?? "");
        $this->role       = (string)($row["role"] ?? "user");
        $this->created_at = (string)($row["created_at"] ?? "");
    }
}
