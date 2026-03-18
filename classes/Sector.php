<?php
class Sector {
    private $conn;
    private $table = "sectors";

    public function __construct($db) {
        $this->conn = $db;
    }

    // ✅ Get all sectors (with project name)
    public function getAll() {
        $query = "SELECT s.*, p.project_name 
                  FROM {$this->table} s
                  LEFT JOIN projects p ON s.project_id = p.id
                  ORDER BY s.id DESC";
        return $this->conn->query($query);
    }

    // ✅ Get single sector
    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            error_log("Sector::getById prepare failed: " . $this->conn->error);
            return null;
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ✅ Add new sector
    public function add($data) {
        $query = "INSERT INTO {$this->table} (sector_name, project_id, details)
                  VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            error_log("Sector::add prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("sis", $data['sector_name'], $data['project_id'], $data['details']);
        return $stmt->execute();
    }

    // ✅ Update sector
    public function update($data) {
        $query = "UPDATE {$this->table}
                  SET sector_name = ?, project_id = ?, details = ?
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            error_log("Sector::update prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("sisi", $data['sector_name'], $data['project_id'], $data['details'], $data['id']);
        return $stmt->execute();
    }

    // ✅ Delete sector
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            error_log("Sector::delete prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
