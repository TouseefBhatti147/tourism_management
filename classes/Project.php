<?php
class Project {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /* =========================================================
       ADD PROJECT
    ========================================================= */
    public function addProject($data) {

        $stmt = $this->conn->prepare("
            INSERT INTO projects 
            (project_name, teaser, project_url, project_details, status, project_images, project_map, create_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->bind_param(
            "ssssiss",
            $data['project_name'],
            $data['teaser'],
            $data['project_url'],
            $data['project_details'],
            $data['status'],
            $data['project_images'],
            $data['project_map']
        );

        if ($stmt->execute()) {
            return ['success'=>true,'message'=>'Project added successfully'];
        }

        return ['success'=>false,'message'=>'Add failed: '.$stmt->error];
    }

    /* =========================================================
       UPDATE PROJECT
    ========================================================= */
    public function updateProject($id, $data, $oldData, $deleteOldImage, $deleteOldMap) {

        // Delete old image
        if ($deleteOldImage && !empty($oldData['project_images'])) {
            $oldFile = __DIR__ . "/../assets/img/projects/" . $oldData['project_images'];
            if (file_exists($oldFile)) unlink($oldFile);
        }

        // Delete old map
        if ($deleteOldMap && !empty($oldData['project_map'])) {
            $oldFile = __DIR__ . "/../assets/img/projects/" . $oldData['project_map'];
            if (file_exists($oldFile)) unlink($oldFile);
        }

        $stmt = $this->conn->prepare("
            UPDATE projects
            SET project_name=?, teaser=?, project_url=?, project_details=?, status=?, project_images=?, project_map=?
            WHERE id=?
        ");

        $stmt->bind_param(
            "ssssissi",
            $data['project_name'],
            $data['teaser'],
            $data['project_url'],
            $data['project_details'],
            $data['status'],
            $data['project_images'],
            $data['project_map'],
            $id
        );

        if ($stmt->execute()) {
            return ['success'=>true,'message'=>'Project updated successfully'];
        }

        return ['success'=>false,'message'=>'Update failed: '.$stmt->error];
    }

    /* =========================================================
       DELETE PROJECT
    ========================================================= */
    public function deleteProject($id) {

        $stmt = $this->conn->prepare("SELECT project_images, project_map FROM projects WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $data = $stmt->get_result()->fetch_assoc();

        if ($data) {
            if (!empty($data['project_images'])) {
                $file = __DIR__ . "/../assets/img/projects/" . $data['project_images'];
                if (file_exists($file)) unlink($file);
            }

            if (!empty($data['project_map'])) {
                $file = __DIR__ . "/../assets/img/projects/" . $data['project_map'];
                if (file_exists($file)) unlink($file);
            }
        }

        $stmt = $this->conn->prepare("DELETE FROM projects WHERE id=?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return ['success'=>true,'message'=>'Project deleted successfully'];
        }

        return ['success'=>false,'message'=>'Delete failed'];
    }

    /* =========================================================
       GET ONE PROJECT
    ========================================================= */
    public function getProject($id) {
        $stmt = $this->conn->prepare("SELECT * FROM projects WHERE id=?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            return ['success'=>true,'data'=>$res->fetch_assoc()];
        }

        return ['success'=>false,'message'=>'Project not found'];
    }

    /* =========================================================
       GET ALL PROJECTS
    ========================================================= */
    public function getAllProjects() {
        $result = $this->conn->query("SELECT * FROM projects ORDER BY id DESC");
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return ['success'=>true,'data'=>$rows];
    }
}
