<?php

class News {

    private $db;
    private $table = "latest_news";

    function __construct($db) {
        $this->db = $db;
    }

    function getAll() {
        $sql = "SELECT * FROM $this->table ORDER BY id DESC";
        return $this->db->query($sql);
    }

    function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    function add($data) {
        $now = date("Y-m-d H:i:s");

        $stmt = $this->db->prepare("
            INSERT INTO $this->table (teaser, details, status, create_date, update_date) 
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->bind_param("sssss",
            $data['teaser'],
            $data['details'],
            $data['status'],
            $now,
            $now
        );

        if ($stmt->execute()) {
            return ["success" => true, "message" => "News added successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }

    function update($data) {
        $now = date("Y-m-d H:i:s");

        $stmt = $this->db->prepare("
            UPDATE $this->table 
            SET teaser=?, details=?, status=?, update_date=? 
            WHERE id=?
        ");

        $stmt->bind_param("ssssi",
            $data['teaser'],
            $data['details'],
            $data['status'],
            $now,
            $data['id']
        );

        if ($stmt->execute()) {
            return ["success" => true, "message" => "News updated successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }

    function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE id=?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return ["success" => true, "message" => "News deleted successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }
}
