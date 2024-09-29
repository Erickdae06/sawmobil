<?php
class Rangking {
    private $conn;
    private $table_name = "rangking";
    public $bobot_subkriteria;
    public $ia; // id_alternatif
    public $ik; // id_kriteria
    public $sub_kriteria; // sub_kriteria
    public $nn2; // nilai_normalisasi
    public $nn3; // bobot_normalisasi
    public $has;
    public $nn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function insert() {
        // Pastikan semua nilai yang diperlukan diisi
        if (empty($this->ia) || empty($this->ik) || empty($this->sub_kriteria) || empty($this->bobot_subkriteria)) {
            echo "Error: All fields must be filled.";
            return false;
        }

        // Check if data already exists
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE id_alternatif = :id_alternatif AND id_kriteria = :id_kriteria";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_alternatif', $this->ia);
        $stmt->bindParam(':id_kriteria', $this->ik);
        $stmt->execute();

        if ($stmt->fetchColumn() > 0) {
            // Update if data exists
            return $this->update();
        } else {
            // Insert new data
            $query = "INSERT INTO " . $this->table_name . " (id_alternatif, id_kriteria, sub_kriteria, bobot_subkriteria) VALUES (:id_alternatif, :id_kriteria, :sub_kriteria, :bobot_subkriteria)";
            $stmt = $this->conn->prepare($query);

            // Bind parameters
            $stmt->bindParam(':id_alternatif', $this->ia);
            $stmt->bindParam(':id_kriteria', $this->ik);
            $stmt->bindParam(':sub_kriteria', $this->sub_kriteria);
            $stmt->bindParam(':bobot_subkriteria', $this->bobot_subkriteria);

            if ($stmt->execute()) {
                return true;
            } else {
                echo 'Insert error: ' . implode(" ", $stmt->errorInfo());
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
        $query = "
            SELECT 
                a.id_alternatif, 
                a.nama_alternatif, 
                b.id_kriteria, 
                b.nama_kriteria, 
                c.sub_kriteria, 
                c.bobot_subkriteria, 
                c.nilai_normalisasi, 
                c.bobot_normalisasi 
            FROM 
                alternatif a 
            JOIN 
                rangking c ON a.id_alternatif = c.id_alternatif
            JOIN 
                kriteria b ON b.id_kriteria = c.id_kriteria
            ORDER BY 
                a.id_alternatif ASC
        ";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            echo "Query preparation failed: " . implode(" ", $this->conn->errorInfo());
            return false;
        }
    
        if (!$stmt->execute()) {
            echo "Query execution failed: " . implode(" ", $stmt->errorInfo());
            return false;
        }
    
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
        $query = "SELECT max(bobot_subkriteria) as mnr1 FROM " . $this->table_name . " WHERE id_kriteria = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $b);
        $stmt->execute();
        return $stmt;
    }

    function readMin($b) {
        $query = "SELECT min(bobot_subkriteria) as mnr2 FROM " . $this->table_name . " WHERE id_kriteria = ? LIMIT 1";
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
        if ($row) {
            $this->ia = $row['id_alternatif'];
            $this->ik = $row['id_kriteria'];
            $this->sub_kriteria = $row['sub_kriteria'];
        }
    }

    function update() {
        $query = "UPDATE " . $this->table_name . " SET bobot_subkriteria = :bobot_subkriteria WHERE id_alternatif = :ia AND id_kriteria = :ik";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':bobot_subkriteria', $this->bobot_subkriteria);
        $stmt->bindParam(':ia', $this->ia);
        $stmt->bindParam(':ik', $this->ik);
        if ($stmt->execute()) {
            return true;
        } else {
            echo 'Update error: ' . implode(" ", $stmt->errorInfo());
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
            echo 'Normalization error: ' . implode(" ", $stmt->errorInfo());
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
            echo 'Hasil update error: ' . implode(" ", $stmt->errorInfo());
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
            echo 'Delete error: ' . implode(" ", $stmt->errorInfo());
            return false;
        }
    }
    
}
?>
