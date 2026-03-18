<?php

class SaleCenter {

    private $db;
    private $table = "sales_center";

    function __construct($db) {
        $this->db = $db;
    }

    function getAll() {
        $sql = "SELECT * FROM $this->table ORDER BY id DESC";
        $result = $this->db->query($sql);

        if (!$result) {
            die("SQL ERROR: " . $this->db->error);
        }

        return $result;
    }

    function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    function add($data, $image) {
        $stmt = $this->db->prepare("INSERT INTO $this->table (name, image, detail, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $data['name'], $image, $data['detail'], $data['status']);

        if ($stmt->execute()) {
            return ["success" => true, "message" => "Sales Center added successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }

    function update($data, $image = null) {

        if ($image) {
            $sql = "UPDATE $this->table SET name=?, image=?, detail=?, status=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssii", $data['name'], $image, $data['detail'], $data['status'], $data['id']);
        } else {
            $sql = "UPDATE $this->table SET name=?, detail=?, status=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssii", $data['name'], $data['detail'], $data['status'], $data['id']);
        }

        if ($stmt->execute()) {
            return ["success" => true, "message" => "Sales Center updated successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }

    function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE id=?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return ["success" => true, "message" => "Deleted successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }
}
