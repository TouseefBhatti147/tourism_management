<?php

class Country {

    private $db;
    private $table = "countries";

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
        $stmt = $this->db->prepare("INSERT INTO $this->table (country_name) VALUES (?)");
        $stmt->bind_param("s", $data['country_name']);

        if ($stmt->execute()) {
            return ["success" => true, "message" => "Country added successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }

    function update($data) {
        $stmt = $this->db->prepare("UPDATE $this->table SET country_name=? WHERE id=?");
        $stmt->bind_param("si", $data['country_name'], $data['id']);

        if ($stmt->execute()) {
            return ["success" => true, "message" => "Country updated successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }

    function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE id=?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return ["success" => true, "message" => "Country deleted successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }
}
