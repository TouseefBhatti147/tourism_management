<?php

class PropertyType {

    private $db;
    private $table = "property_types"; // correct table name

    function __construct($db) {
        $this->db = $db;
    }

    function add($data) {
        $sql = "INSERT INTO $this->table (title, short, short_sm) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $data['title'], $data['short'], $data['short_sm']);

        if ($stmt->execute()) {
            return ["success" => true, "message" => "Property Type added successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }

    function update($data) {
        $sql = "UPDATE $this->table SET title=?, short=?, short_sm=? WHERE property_type_id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssi", $data['title'], $data['short'], $data['short_sm'], $data['property_type_id']);

        if ($stmt->execute()) {
            return ["success" => true, "message" => "Property Type updated successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }

    function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE property_type_id=?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return ["success" => true, "message" => "Deleted successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }

    function getAll() {
        $sql = "SELECT * FROM $this->table ORDER BY property_type_id DESC";
        $result = $this->db->query($sql);

        if (!$result) {
            die("SQL ERROR: " . $this->db->error . "<br>QUERY: " . $sql);
        }

        return $result;
    }
}
