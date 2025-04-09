<?php
class Repository {
    protected PDO $conn;
    protected string $table;

    public function __construct(PDO $conn, string $table) {
        $this->conn = $conn;
        $this->table = $table;
    }

    public function findAll(): array {
        $stmt = $this->conn->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function create(array $data): bool {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($col) => ":$col", array_keys($data)));

        $stmt = $this->conn->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
        return $stmt->execute($data);
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}

