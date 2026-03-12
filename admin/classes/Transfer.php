<?php
class Transfer {

    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    /* -----------------------------------------------------
       LIST with Search + Pagination
    ----------------------------------------------------- */
    public function getAll($search = "", $limit = 20, $offset = 0) {

        $searchSql = "";
        if ($search != "") {
            $s = $this->db->real_escape_string($search);
            $searchSql = " AND (
                p.plot_detail_address LIKE '%$s%' OR
                m1.name LIKE '%$s%' OR
                m2.name LIKE '%$s%'
            )";
        }

        $sql = "
            SELECT 
                t.*,
                p.plot_detail_address,
                p.plot_size,
                m1.name AS from_member,
                m2.name AS to_member
            FROM transferplot t
            LEFT JOIN plots p ON p.id = t.plot_id
            LEFT JOIN member m1 ON m1.id = t.transferfrom_id
            LEFT JOIN member m2 ON m2.id = t.transferto_id
            WHERE 1 $searchSql
            ORDER BY t.id DESC
            LIMIT $limit OFFSET $offset
        ";

        return $this->db->query($sql);
    }

    /* -----------------------------------------------------
       TOTAL COUNT
    ----------------------------------------------------- */
    public function getTotal($search = "") {
        $searchSql = "";
        if ($search != "") {
            $s = $this->db->real_escape_string($search);
            $searchSql = " AND (
                p.plot_detail_address LIKE '%$s%' OR
                m1.name LIKE '%$s%' OR
                m2.name LIKE '%$s%'
            )";
        }

        $sql = "
            SELECT COUNT(*) AS cnt
            FROM transferplot t
            LEFT JOIN plots p ON p.id = t.plot_id
            LEFT JOIN member m1 ON m1.id = t.transferfrom_id
            LEFT JOIN member m2 ON m2.id = t.transferto_id
            WHERE 1 $searchSql
        ";

        $res = $this->db->query($sql);

        if (!$res) return 0;

        $row = $res->fetch_assoc();
        return $row['cnt'] ?? 0;
    }


    /* -----------------------------------------------------
       ADD
    ----------------------------------------------------- */
    public function add($data){

        $sql = "INSERT INTO transferplot 
                (plot_id, transferfrom_id, transferto_id, uid, status, create_date)
                VALUES (?,?,?,?,?,?)";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            "iiisss",
            $data['plot_id'],
            $data['transferfrom_id'],
            $data['transferto_id'],
            $data['uid'],
            $data['status'],
            $data['create_date']
        );

        return $stmt->execute();
    }


    /* -----------------------------------------------------
       DELETE
    ----------------------------------------------------- */
    public function delete($id){
        $id = intval($id);
        return $this->db->query("DELETE FROM transferplot WHERE id=$id");
    }

}
