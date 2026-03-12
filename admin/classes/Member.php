<?php

class Member
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /* ------------------------------------
        GET TOTAL RECORDS (Pagination)
    ------------------------------------ */
    public function getTotal($search = "")
    {
        $sql = "SELECT COUNT(*) AS total FROM member WHERE 1 ";

        if (!empty($search)) {
            $search = $this->db->real_escape_string($search);
            $sql .= " AND (
                        name LIKE '%$search%' OR
                        username LIKE '%$search%' OR
                        phone LIKE '%$search%' OR
                        cnic LIKE '%$search%'
                     ) ";
        }

        $res = $this->db->query($sql);

        if (!$res) {
            die("SQL ERROR in getTotal(): " . $this->db->error . "<br><br>QUERY: " . $sql);
        }

        $row = $res->fetch_assoc();
        return $row['total'] ?? 0;
    }

    /* ------------------------------------
        GET ALL MEMBERS (With Pagination)
    ------------------------------------ */
    public function getAll($search = "", $limit = 10, $offset = 0)
    {
        $sql = "SELECT m.*, 
                       c.city_name,
                       co.country_name
                FROM member m
                LEFT JOIN cities c ON c.id = m.city_id
                LEFT JOIN countries co ON co.id = m.country_id
                WHERE 1 ";

        if (!empty($search)) {
            $search = $this->db->real_escape_string($search);
            $sql .= " AND (
                        m.name LIKE '%$search%' OR
                        m.username LIKE '%$search%' OR
                        m.phone LIKE '%$search%' OR
                        m.cnic LIKE '%$search%'
                     ) ";
        }

        $sql .= " ORDER BY m.id DESC LIMIT $limit OFFSET $offset";

        $res = $this->db->query($sql);

        if (!$res) {
            die("SQL ERROR in getAll(): " . $this->db->error . "<br><br>QUERY: " . $sql);
        }

        return $res;
    }

    /* ------------------------------------
        GET SINGLE MEMBER BY ID
    ------------------------------------ */
    public function getById($id)
    {
        $stmt = $this->db->prepare(
            "SELECT m.*, 
                    c.city_name,
                    co.country_name
             FROM member m
             LEFT JOIN cities c ON c.id = m.city_id
             LEFT JOIN countries co ON co.id = m.country_id
             WHERE m.id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /* ------------------------------------
        ADD NEW MEMBER
    ------------------------------------ */
    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO member 
            (name, username, sodowo, title, cnic, image, address, city_id, phone, email, 
             country_id, state, nomineename, nomineecnic, rwa, password, status, fp, 
             mtype, login_status, create_date, dob, business_title)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "sssssssssssssssssssssss",
            $data['name'],
            $data['username'],
            $data['sodowo'],
            $data['title'],
            $data['cnic'],
            $data['image'],
            $data['address'],
            $data['city_id'],
            $data['phone'],
            $data['email'],
            $data['country_id'],
            $data['state'],
            $data['nomineename'],
            $data['nomineecnic'],
            $data['rwa'],
            $data['password'],
            $data['status'],
            $data['fp'],
            $data['mtype'],
            $data['login_status'],
            $data['create_date'],
            $data['dob'],
            $data['business_title']
        );

        return $stmt->execute();
    }

    /* ------------------------------------
        UPDATE MEMBER
    ------------------------------------ */
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE member SET
            name=?, username=?, sodowo=?, title=?, cnic=?, image=?, address=?, city_id=?, phone=?, email=?,
            country_id=?, state=?, nomineename=?, nomineecnic=?, rwa=?, password=?, status=?, fp=?, 
            mtype=?, login_status=?, create_date=?, dob=?, business_title=?
            WHERE id=?
        ");

        $stmt->bind_param(
            "sssssssssssssssssssssssi",
            $data['name'],
            $data['username'],
            $data['sodowo'],
            $data['title'],
            $data['cnic'],
            $data['image'],
            $data['address'],
            $data['city_id'],
            $data['phone'],
            $data['email'],
            $data['country_id'],
            $data['state'],
            $data['nomineename'],
            $data['nomineecnic'],
            $data['rwa'],
            $data['password'],
            $data['status'],
            $data['fp'],
            $data['mtype'],
            $data['login_status'],
            $data['create_date'],
            $data['dob'],
            $data['business_title'],
            $id
        );

        return $stmt->execute();
    }

    /* ------------------------------------
        DELETE MEMBER
    ------------------------------------ */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM member WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
