<?php
class Charges {
    private $conn;
    private $table = "charges";

    public function __construct($db) {
        $this->conn = $db;
    }

    // === Get All with pagination + search + project filter ===
    public function getAll($limit, $offset, $search = '', $project_id = '') {
        $where = "1=1";
        $params = [];
        $types  = '';

        if ($search !== '') {
            $where .= " AND (name LIKE CONCAT('%', ?, '%') OR note LIKE CONCAT('%', ?, '%'))";
            $params[] = $search;
            $params[] = $search;
            $types .= "ss";
        }

        if ($project_id !== '') {
            $where .= " AND project_id = ?";
            $params[] = $project_id;
            $types .= "s";
        }

        $sql = "SELECT c.*, p.project_name 
                FROM {$this->table} c 
                LEFT JOIN projects p ON c.project_id = p.id 
                WHERE $where 
                ORDER BY c.id DESC 
                LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= "ii";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed (getAll): " . $this->conn->error);
        }

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result();
    }

    // === Count all ===
    public function countAll($search = '', $project_id = '') {
        $where = "1=1";
        $params = [];
        $types  = '';

        if ($search !== '') {
            $where .= " AND (name LIKE CONCAT('%', ?, '%') OR note LIKE CONCAT('%', ?, '%'))";
            $params[] = $search;
            $params[] = $search;
            $types .= "ss";
        }

        if ($project_id !== '') {
            $where .= " AND project_id = ?";
            $params[] = $project_id;
            $types .= "s";
        }

        $sql = "SELECT COUNT(*) AS total FROM {$this->table} WHERE $where";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed (countAll): " . $this->conn->error);
        }

        if (!empty($params)) $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return (int)$res['total'];
    }

    // === Add ===
    public function add($data) {
        $sql = "INSERT INTO {$this->table} (name, note, monthly, total, type, project_id)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return ['success' => false, 'error' => $this->conn->error];

        $stmt->bind_param(
            "ssssss",
            $data['name'],
            $data['note'],
            $data['monthly'],
            $data['total'],
            $data['type'],
            $data['project_id']
        );

        if ($stmt->execute()) return ['success' => true];
        return ['success' => false, 'error' => $stmt->error];
    }

    // === Update ===
    public function update($data) {
        $sql = "UPDATE {$this->table}
                SET name=?, note=?, monthly=?, total=?, type=?, project_id=?
                WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return ['success' => false, 'error' => $this->conn->error];

        $stmt->bind_param(
            "ssssssi",
            $data['name'],
            $data['note'],
            $data['monthly'],
            $data['total'],
            $data['type'],
            $data['project_id'],
            $data['id']
        );

        if ($stmt->execute()) return ['success' => true];
        return ['success' => false, 'error' => $stmt->error];
    }

    // === Delete ===
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        if (!$stmt) return ['success' => false, 'error' => $this->conn->error];
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) return ['success' => true];
        return ['success' => false, 'error' => $stmt->error];
    }
}
?>
