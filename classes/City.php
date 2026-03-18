<?php

class City {

    private $db;
    private $table = "cities";

    function __construct($db) {
        $this->db = $db;
    }

    function getAll($country_id = null) {
        if ($country_id) {
            $stmt = $this->db->prepare("
                SELECT c.*, co.country_name 
                FROM $this->table c
                LEFT JOIN countries co ON co.id = c.country_id
                WHERE c.country_id = ?
                ORDER BY c.id DESC
            ");
            $stmt->bind_param("i", $country_id);
            $stmt->execute();
            return $stmt->get_result();
        }

        return $this->db->query("
            SELECT c.*, co.country_name 
            FROM $this->table c
            LEFT JOIN countries co ON co.id = c.country_id
            ORDER BY c.id DESC
        ");
    }

    function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    function add($data) {
        $stmt = $this->db->prepare("
            INSERT INTO $this->table (city_name, country_id, zipcode) 
            VALUES (?, ?, ?)
        ");

        $stmt->bind_param("sis",
            $data['city_name'],
            $data['country_id'],
            $data['zipcode']
        );

        if ($stmt->execute()) {
            return ["success" => true, "message" => "City added successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }

    function update($data) {
        $stmt = $this->db->prepare("
            UPDATE $this->table 
            SET city_name=?, country_id=?, zipcode=? 
            WHERE id=?
        ");

        $stmt->bind_param("sisi",
            $data['city_name'],
            $data['country_id'],
            $data['zipcode'],
            $data['id']
        );

        if ($stmt->execute()) {
            return ["success" => true, "message" => "City updated successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }

    function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE id=?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return ["success" => true, "message" => "City deleted successfully"];
        }
        return ["success" => false, "message" => $stmt->error];
    }
}
