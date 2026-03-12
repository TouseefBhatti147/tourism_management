<?php
class PlotSize {
    private $conn;
    private $table = "size_cat";

    public function __construct($db) {
        $this->conn = $db;
    }

    // === Fetch all with pagination and optional search ===
    public function getAll($limit, $offset, $search = '') {
        if ($search !== '') {
            $sql = "SELECT * FROM {$this->table} 
                    WHERE size LIKE CONCAT('%', ?, '%') 
                       OR type LIKE CONCAT('%', ?, '%') 
                       OR code LIKE CONCAT('%', ?, '%') 
                    ORDER BY id DESC 
                    LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssii", $search, $search, $search, $limit, $offset);
        } else {
            $sql = "SELECT * FROM {$this->table} 
                    ORDER BY id DESC 
                    LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $limit, $offset);
        }

        $stmt->execute();
        return $stmt->get_result();
    }

    // === Count total ===
    public function countAll($search = '') {
        if ($search !== '') {
            $sql = "SELECT COUNT(*) AS total FROM {$this->table} 
                    WHERE size LIKE CONCAT('%', ?, '%') 
                       OR type LIKE CONCAT('%', ?, '%') 
                       OR code LIKE CONCAT('%', ?, '%')";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sss", $search, $search, $search);
        } else {
            $sql = "SELECT COUNT(*) AS total FROM {$this->table}";
            $stmt = $this->conn->prepare($sql);
        }

        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return (int)$res['total'];
    }

    // === Add new record ===
    public function add($data) {
        $sql = "INSERT INTO {$this->table} (size, type, code) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return ['success' => false, 'error' => $this->conn->error];

        $stmt->bind_param("sss", $data['size'], $data['type'], $data['code']);
        if ($stmt->execute()) return ['success' => true];
        return ['success' => false, 'error' => $stmt->error];
    }

    // === Update existing ===
    public function update($data) {
        $sql = "UPDATE {$this->table} SET size=?, type=?, code=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return ['success' => false, 'error' => $this->conn->error];

        $stmt->bind_param("sssi", $data['size'], $data['type'], $data['code'], $data['id']);
        if ($stmt->execute()) return ['success' => true];
        return ['success' => false, 'error' => $stmt->error];
    }

    // === Delete ===
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        if (!$stmt) return ['success' => false, 'error' => $this->conn->error];
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) return ['success' => true];
        return ['success' => false, 'error' => $stmt->error];
    }
}
?>
