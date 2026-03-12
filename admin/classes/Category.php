<?php
class Category {
    private $conn;
    private $table = "categories";

    public function __construct($db) {
        $this->conn = $db;
    }

    // ✅ Get all categories with pagination
    public function getAll($limit, $offset) {
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }

    // ✅ Count total records for pagination
    public function countAll() {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM {$this->table}");
        return $result->fetch_assoc()['total'];
    }

    // ✅ Add
    public function add($data) {
        $query = "INSERT INTO {$this->table} (title, name, charges) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $data['title'], $data['name'], $data['charges']);
        return $stmt->execute();
    }

    // ✅ Update
    public function update($data) {
        $query = "UPDATE {$this->table} SET title=?, name=?, charges=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssi", $data['title'], $data['name'], $data['charges'], $data['id']);
        return $stmt->execute();
    }

    // ✅ Delete
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // ✅ Get by ID
    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
