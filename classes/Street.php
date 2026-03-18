<?php
class Street {
    private $conn;
    private $table = "streets";

    public function __construct($db) {
        $this->conn = $db;
    }

    // ✅ Fetch all streets with project and sector names
    public function getAll() {
        $query = "SELECT s.*, p.project_name, sec.sector_name 
                  FROM {$this->table} s
                  LEFT JOIN projects p ON s.project_id = p.id
                  LEFT JOIN sectors sec ON s.sector_id = sec.sector_id
                  ORDER BY s.id DESC";
        return $this->conn->query($query);
    }

    // ✅ Get single street
    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ✅ Add street
    public function add($data) {
        $query = "INSERT INTO {$this->table} (project_id, sector_id, street, create_date, modify_date)
                  VALUES (?, ?, ?, NOW(), NOW())";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;
        $stmt->bind_param("iss", $data['project_id'], $data['sector_id'], $data['street']);
        return $stmt->execute();
    }

    // ✅ Update street
    public function update($data) {
        $query = "UPDATE {$this->table}
                  SET project_id = ?, sector_id = ?, street = ?, modify_date = NOW()
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;
        $stmt->bind_param("issi", $data['project_id'], $data['sector_id'], $data['street'], $data['id']);
        return $stmt->execute();
    }

    // ✅ Delete street
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
