<?php
include_once 'includes/db.inc.php'; // Pastikan koneksi database
include_once 'includes/sub_kriteria.inc.php'; // Sertakan kelas SubKriteria

$pgn = new SubKriteria($db);

if (isset($_GET['kriteria_id'])) {
    $kriteriaId = $_GET['kriteria_id'];
    $stmt = $pgn->readByKriteria($kriteriaId);
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='{$row['id_sub_kriteria']}'>{$row['nama_sub_kriteria']}</option>";
    }
} else {
    echo "<option value=''>Pilih sub-kriteria</option>"; // Menampilkan opsi default jika tidak ada kriteria yang dipilih
}
?>
