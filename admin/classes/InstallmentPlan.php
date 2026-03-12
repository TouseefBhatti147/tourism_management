<?php

class InstallmentPlan
{
    private $db;
    private $table = "installment_plan";

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Get all plans with project, size and property type
    public function getAll()
    {
        $sql = "
            SELECT ip.*,
                   p.project_name,
                   sc.size AS size_title,
                   pt.title AS property_title
            FROM {$this->table} ip
            LEFT JOIN projects p ON p.id = ip.project_id
            LEFT JOIN size_cat sc ON sc.id = ip.size_cat_id
            LEFT JOIN property_types pt ON pt.property_type_id = ip.p_type
            ORDER BY ip.id DESC
        ";

        $result = $this->db->query($sql);
        if (!$result) {
            die('SQL Error: ' . $this->db->error);
        }
        return $result;
    }

    // Get single plan by ID
    public function getById($id)
    {
        $id = (int)$id;
        $sql = "SELECT * FROM {$this->table} WHERE id = {$id} LIMIT 1";
        $result = $this->db->query($sql);
        if (!$result) {
            die('SQL Error: ' . $this->db->error);
        }
        return $result->fetch_assoc();
    }

    // Delete plan
    public function delete($id)
    {
        $id = (int)$id;
        $sql = "DELETE FROM {$this->table} WHERE id = {$id} LIMIT 1";
        if ($this->db->query($sql)) {
            return ["success" => true, "message" => "Installment plan deleted successfully"];
        }
        return ["success" => false, "message" => "Delete failed: " . $this->db->error];
    }
}
