<?php
include_once 'includes/db.inc.php'; 
include_once 'includes/sub_kriteria.inc.php'; 

$pgn = new SubKriteria($db);

if (isset($_GET['kriteria_id'])) {
    $kriteriaId = $_GET['kriteria_id'];
    $stmt = $pgn->readByKriteria($kriteriaId);
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='{$row['id_sub_kriteria']}'>{$row['nama_sub_kriteria']}</option>";
    }
} else {
    echo "<option value=''>Pilih sub-kriteria</option>";
}
?>
