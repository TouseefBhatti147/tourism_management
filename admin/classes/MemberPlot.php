<?php
class MemberPlot {

    private $db;
    private $debug = true; // SHOW SQL ERRORS

    public function __construct($db){
        $this->db = $db;
    }

    // -------------------------------------------------------------
    // GET ALL with Filters (search + pagination)
    // -------------------------------------------------------------
    public function getAll($filters = [], $limit = 20, $offset = 0){

        $search = $filters['search'] ?? '';
        $search = $this->db->real_escape_string($search);

        $sql = "
            SELECT 
                mp.*,
                m.name AS member_name,
                p.plot_size,
                p.plot_detail_address,
                proj.project_name,
                sec.sector_name,
                st.street AS street_name
            FROM memberplot mp
            LEFT JOIN member m ON m.id = mp.member_id
            LEFT JOIN plots p ON p.id = mp.plot_id
            LEFT JOIN projects proj ON proj.id = p.project_id
            LEFT JOIN sectors sec ON sec.sector_id = p.sector_id
            LEFT JOIN streets st ON st.id = p.street_id
            WHERE 1
        ";

        if($search !== ""){
            $sql .= "
                AND (
                        m.name LIKE '%$search%'
                        OR mp.status LIKE '%$search%'
                        OR mp.plotno LIKE '%$search%'
                    )
            ";
        }

        $sql .= " ORDER BY mp.id DESC LIMIT $limit OFFSET $offset";

        $result = $this->db->query($sql);

        if(!$result){
            if ($this->debug) {
                die("SQL ERROR: " . $this->db->error . "<br><br>Query: $sql");
            }
            return false;
        }

        return $result;
    }

    // -------------------------------------------------------------
    // Total Count (same filters as getAll)
    // -------------------------------------------------------------
    public function getTotal($filters = []){

        $search = $filters['search'] ?? '';
        $search = $this->db->real_escape_string($search);

        $sql = "
            SELECT COUNT(*) AS cnt
            FROM memberplot mp
            LEFT JOIN member m ON m.id = mp.member_id
            WHERE 1
        ";

        if($search !== ""){
            $sql .= "
                AND (
                        m.name LIKE '%$search%'
                        OR mp.status LIKE '%$search%'
                        OR mp.plotno LIKE '%$search%'
                    )
            ";
        }

        $result = $this->db->query($sql);

        if(!$result){
            if ($this->debug) {
                die("COUNT ERROR: " . $this->db->error . "<br><br>Query: $sql");
            }
            return 0;
        }

        $row = $result->fetch_assoc();
        return $row['cnt'] ?? 0;
    }

    // -------------------------------------------------------------
    // GET by ID
    // -------------------------------------------------------------
    public function getById($id){
        $id = (int)$id;
        $sql = "SELECT * FROM memberplot WHERE id=$id LIMIT 1";
        return $this->db->query($sql)->fetch_assoc();
    }

    // -------------------------------------------------------------
    // ADD
    // -------------------------------------------------------------
    public function add($data){
        $sql = "
            INSERT INTO memberplot 
            (plot_id, member_id, create_date, noi, insplan, status, plotno, msno, uid)
            VALUES (?,?,?,?,?,?,?,?,?)
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            "iississsi",
            $data['plot_id'],
            $data['member_id'],
            $data['create_date'],
            $data['noi'],
            $data['insplan'],
            $data['status'],
            $data['plotno'],
            $data['msno'],
            $data['uid']
        );

        return $stmt->execute();
    }

    // -------------------------------------------------------------
    // UPDATE
    // -------------------------------------------------------------
    public function update($data){
        $sql = "
            UPDATE memberplot SET 
                plot_id=?, 
                member_id=?, 
                create_date=?, 
                noi=?, 
                insplan=?,
                status=?, 
                plotno=?, 
                msno=?
            WHERE id=?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            "iississsi",
            $data['plot_id'],
            $data['member_id'],
            $data['create_date'],
            $data['noi'],
            $data['insplan'],
            $data['status'],
            $data['plotno'],
            $data['msno'],
            $data['id']
        );

        return $stmt->execute();
    }

    // -------------------------------------------------------------
    // DELETE
    // -------------------------------------------------------------
    public function delete($id){
        $id = (int)$id;
        return $this->db->query("DELETE FROM memberplot WHERE id=$id");
    }
}
