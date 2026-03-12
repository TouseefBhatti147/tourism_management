<?php

class Slider {

    private $db;
    private $table = "slider";

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

    function add($data, $imageName) {
        $stmt = $this->db->prepare("INSERT INTO $this->table (title, detail, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $data['title'], $data['detail'], $imageName);

        if ($stmt->execute()) {
            return ["success" => true, "message" => "Slider added successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }

    function update($data, $imageName = null) {

        if ($imageName) {
            $sql = "UPDATE $this->table SET title=?, detail=?, image=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssi", $data['title'], $data['detail'], $imageName, $data['id']);
        } else {
            $sql = "UPDATE $this->table SET title=?, detail=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssi", $data['title'], $data['detail'], $data['id']);
        }

        if ($stmt->execute()) {
            return ["success" => true, "message" => "Slider updated successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }

    function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE id=?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return ["success" => true, "message" => "Slider deleted successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }
}
