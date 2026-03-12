<?php
class Pagination {
    private $conn;
    public $table;
    public $perPage;
    public $page;
    public $totalRows;
    public $offset;

    public function __construct($db, $table, $perPage = 10) {
        $this->conn = $db;
        $this->table = $table;
        $this->perPage = $perPage;
        $this->page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($this->page < 1) $this->page = 1;
        $this->offset = ($this->page - 1) * $this->perPage;
        $this->setTotalRows();
    }

    private function setTotalRows() {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM {$this->table}");
        $row = $result->fetch_assoc();
        $this->totalRows = $row['total'];
    }

    public function getTotalPages() {
        return ceil($this->totalRows / $this->perPage);
    }

    public function renderLinks($baseUrl) {
        $totalPages = $this->getTotalPages();
        if ($totalPages <= 1) return '';

        $html = '<ul class="pagination pagination-sm m-0 float-end">';
        $prev = max(1, $this->page - 1);
        $next = min($totalPages, $this->page + 1);

        $html .= "<li class='page-item'><a class='page-link' href='{$baseUrl}?page={$prev}'>«</a></li>";

        for ($i = 1; $i <= $totalPages; $i++) {
            $active = $i == $this->page ? 'active' : '';
            $html .= "<li class='page-item {$active}'><a class='page-link' href='{$baseUrl}?page={$i}'>{$i}</a></li>";
        }

        $html .= "<li class='page-item'><a class='page-link' href='{$baseUrl}?page={$next}'>»</a></li>";
        $html .= '</ul>';

        return $html;
    }
}
?>
