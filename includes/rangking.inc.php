<?php
class Rangking {
    private $conn;
    private $table_name = "rangking";

    public $ia;
    public $ik;
    public $nn;
    public $nn2;
    public $nn3;
    public $mnr1;
    public $mnr2;
    public $sub_kriteria;
    public $has;

    public function __construct($db) {
        $this->conn = $db;
    }

    function insert() {
        // Memeriksa apakah data sudah ada
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE id_alternatif = :id_alternatif AND id_kriteria = :id_kriteria";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_alternatif', $this->ia);
        $stmt->bindParam(':id_kriteria', $this->ik);
        $stmt->execute();

        if ($stmt->fetchColumn() > 0) {
            // Jika data sudah ada, lakukan update
            return $this->update();
        } else {
            // Jika data belum ada, lakukan insert
            $query = "INSERT INTO " . $this->table_name . " (id_alternatif, id_kriteria, nilai_rangking) VALUES (:id_alternatif, :id_kriteria, :nilai_rangking)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_alternatif', $this->ia);
            $stmt->bindParam(':id_kriteria', $this->ik);
            $stmt->bindParam(':nilai_rangking', $this->nn);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function readKhusus() {
        $query = "SELECT * FROM alternatif a, kriteria b, rangking c WHERE a.id_alternatif = c.id_alternatif AND b.id_kriteria = c.id_kriteria ORDER BY a.id_alternatif ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function readR($a) {
        $query = "SELECT * FROM alternatif a, kriteria b, rangking c WHERE a.id_alternatif = c.id_alternatif AND b.id_kriteria = c.id_kriteria AND c.id_alternatif = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $a);
        $stmt->execute();
        return $stmt;
    }

    function readMax($b) {
        $query = "SELECT max(nilai_rangking) as mnr1 FROM " . $this->table_name . " WHERE id_kriteria = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $b);
        $stmt->execute();
        return $stmt;
    }

    function readMin($b) {
        $query = "SELECT min(nilai_rangking) as mnr2 FROM " . $this->table_name . " WHERE id_kriteria = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $b);
        $stmt->execute();
        return $stmt;
    }

    function readHasil($a) {
        $query = "SELECT sum(bobot_normalisasi) as bbn FROM " . $this->table_name . " WHERE id_alternatif = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $a);
        $stmt->execute();
        return $stmt;
    }

    function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_alternatif = ? AND id_kriteria = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->ia);
        $stmt->bindParam(2, $this->ik);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->ia = $row['id_alternatif'];
        $this->ik = $row['id_kriteria'];
        $this->nn = $row['nilai_rangking'];
    }

    function update() {
        $query = "UPDATE " . $this->table_name . " SET nilai_rangking = :nn WHERE id_alternatif = :ia AND id_kriteria = :ik";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nn', $this->nn);
        $stmt->bindParam(':ia', $this->ia);
        $stmt->bindParam(':ik', $this->ik);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function normalisasi() {
        $query = "UPDATE " . $this->table_name . " SET nilai_normalisasi = :nn2, bobot_normalisasi = :nn3 WHERE id_alternatif = :ia AND id_kriteria = :ik";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nn2', $this->nn2);
        $stmt->bindParam(':nn3', $this->nn3);
        $stmt->bindParam(':ia', $this->ia);
        $stmt->bindParam(':ik', $this->ik);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function hasil() {
        $query = "UPDATE alternatif SET hasil_alternatif = :has WHERE id_alternatif = :ia";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':has', $this->has);
        $stmt->bindParam(':ia', $this->ia);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_alternatif = ? AND id_kriteria = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->ia);
        $stmt->bindParam(2, $this->ik);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
