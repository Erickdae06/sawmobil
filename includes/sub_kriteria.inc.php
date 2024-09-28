<?php
class SubKriteria {
    private $conn;
    private $table_name = "sub_kriteria";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readByKriteria($kriteriaId) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_kriteria = :kriteriaId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':kriteriaId', $kriteriaId);
        $stmt->execute();
        return $stmt;
    }

    public function readById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_sub_kriteria = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;
    }
}
?>
