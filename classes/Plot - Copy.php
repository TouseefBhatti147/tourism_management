<?php
class Plot
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // ---------------------------------------------------------
    // GET ALL PLOTS (with joins + filters)
    // ---------------------------------------------------------
    public function getAll($search, $limit, $offset, $filters = [])
    {
        $where = " WHERE 1 ";

        if (!empty($search)) {
            $s = $this->db->real_escape_string($search);
            $where .= " AND (
                p.plot_detail_address LIKE '%$s%' OR
                p.plot_size LIKE '%$s%' OR
                p.location LIKE '%$s%'
            ) ";
        }

        if (!empty($filters['project_id'])) {
            $where .= " AND p.project_id = '" . $this->db->real_escape_string($filters['project_id']) . "'";
        }

        if (!empty($filters['sector_id'])) {
            $where .= " AND TRIM(p.sector_id) = '" . $this->db->real_escape_string($filters['sector_id']) . "'";
        }

        if (!empty($filters['street_id'])) {
            $where .= " AND TRIM(p.street_id) = '" . $this->db->real_escape_string($filters['street_id']) . "'";
        }

        if (!empty($filters['size_cat_id'])) {
            $where .= " AND p.size_cat_id = '" . $this->db->real_escape_string($filters['size_cat_id']) . "'";
        }

        if (!empty($filters['property_type'])) {
            $where .= " AND p.category_id = '" . $this->db->real_escape_string($filters['property_type']) . "'";
        }

        $sql = "
            SELECT 
                p.*,
                pr.project_name,
                sec.sector_name,
                st.street,
                sc.size AS size_name,
                pt.title AS property_type
            FROM plots p
            LEFT JOIN projects pr ON pr.id = p.project_id
            LEFT JOIN sectors sec ON TRIM(sec.sector_id) = TRIM(p.sector_id)
            LEFT JOIN streets st ON TRIM(st.id) = TRIM(p.street_id)
            LEFT JOIN size_cat sc ON sc.id = p.size_cat_id
            LEFT JOIN property_types pt ON pt.property_type_id = p.category_id
            $where
            ORDER BY p.id DESC
            LIMIT $offset, $limit
        ";

        return $this->db->query($sql);
    }

    // ---------------------------------------------------------
    // GET TOTAL
    // ---------------------------------------------------------
    public function getTotal($search, $filters = [])
    {
        $where = " WHERE 1 ";

        if (!empty($search)) {
            $s = $this->db->real_escape_string($search);
            $where .= " AND (
                p.plot_detail_address LIKE '%$s%' OR
                p.plot_size LIKE '%$s%' OR
                p.location LIKE '%$s%'
            ) ";
        }

        if (!empty($filters['project_id'])) {
            $where .= " AND p.project_id = '" . $this->db->real_escape_string($filters['project_id']) . "'";
        }

        if (!empty($filters['sector_id'])) {
            $where .= " AND TRIM(p.sector_id) = '" . $this->db->real_escape_string($filters['sector_id']) . "'";
        }

        if (!empty($filters['street_id'])) {
            $where .= " AND TRIM(p.street_id) = '" . $this->db->real_escape_string($filters['street_id']) . "'";
        }

        if (!empty($filters['size_cat_id'])) {
            $where .= " AND p.size_cat_id = '" . $this->db->real_escape_string($filters['size_cat_id']) . "'";
        }

        if (!empty($filters['property_type'])) {
            $where .= " AND p.category_id = '" . $this->db->real_escape_string($filters['property_type']) . "'";
        }

        $sql = "SELECT COUNT(*) AS total FROM plots p $where";
        $row = $this->db->query($sql)->fetch_assoc();

        return (int)$row['total'];
    }

    // ---------------------------------------------------------
    // GET BY ID
    // ---------------------------------------------------------
    public function getById($id)
    {
        $id = (int)$id;
        $res = $this->db->query("SELECT * FROM plots WHERE id = $id");
        return $res ? $res->fetch_assoc() : null;
    }

    // ---------------------------------------------------------
    // ADD (no `type` column)
    // ---------------------------------------------------------
    public function add($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO plots
            (project_id, sector_id, street_id, plot_detail_address, plot_size, size_cat_id,
             installment, price, basic_price, category_id, location, plot_dimension, status, create_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        if (!$stmt) {
            return false;
        }

        // project_id (i), sector_id (i), street_id (i) – stored as numeric IDs
        // Types: i i i s s i i s s i s s s   = 13 params
        $stmt->bind_param(
            "iiissiississs",
            $data['project_id'],          // i
            $data['sector_id'],           // i
            $data['street_id'],           // i
            $data['plot_detail_address'], // s
            $data['plot_size'],           // s
            $data['size_cat_id'],         // i
            $data['installment'],         // i
            $data['price'],               // s
            $data['basic_price'],         // s
            $data['category_id'],         // i
            $data['location'],            // s
            $data['plot_dimension'],      // s
            $data['status']               // s
        );

        return $stmt->execute();
    }

    // ---------------------------------------------------------
    // UPDATE (no `type` column)
    // ---------------------------------------------------------
    public function update($data)
    {
        $stmt = $this->db->prepare("
            UPDATE plots SET
                project_id = ?,
                sector_id = ?,
                street_id = ?,
                plot_detail_address = ?,
                plot_size = ?,
                size_cat_id = ?,
                installment = ?,
                price = ?,
                basic_price = ?,
                category_id = ?,
                location = ?,
                plot_dimension = ?,
                status = ?,
                modify_date = NOW()
            WHERE id = ?
        ");

        if (!$stmt) {
            return false;
        }

        // 14 params: same as add() + id
        // Types: i i i s s i i s s i s s s i
        $stmt->bind_param(
            "iiissiississsi",
            $data['project_id'],          // i
            $data['sector_id'],           // i
            $data['street_id'],           // i
            $data['plot_detail_address'], // s
            $data['plot_size'],           // s
            $data['size_cat_id'],         // i
            $data['installment'],         // i
            $data['price'],               // s
            $data['basic_price'],         // s
            $data['category_id'],         // i
            $data['location'],            // s
            $data['plot_dimension'],      // s
            $data['status'],              // s
            $data['id']                   // i
        );

        return $stmt->execute();
    }

    // ---------------------------------------------------------
    // DELETE
    // ---------------------------------------------------------
    public function delete($id)
    {
        $id = (int)$id;
        return $this->db->query("DELETE FROM plots WHERE id = $id");
    }

    // ---------------------------------------------------------
    // SECTORS BY PROJECT  ✅ uses sectors.sector_id + project_id (varchar)
    // ---------------------------------------------------------
    public function getSectorsByProject($projectId)
    {
        $projectId = $this->db->real_escape_string($projectId);

        return $this->db->query("
            SELECT sector_id, sector_name
            FROM sectors
            WHERE project_id = '$projectId'
            ORDER BY sector_name
        ");
    }

    // ---------------------------------------------------------
    // STREETS BY SECTOR  ✅ streets.sector_id must store sector_id
    // ---------------------------------------------------------
    public function getStreetsBySector($sectorId)
    {
        $sectorId = $this->db->real_escape_string($sectorId);

        return $this->db->query("
            SELECT id, street
            FROM streets
            WHERE sector_id = '$sectorId'
            ORDER BY street
        ");
    }
}
?>
