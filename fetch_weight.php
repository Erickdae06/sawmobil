<?php
include_once 'includes/db.inc.php';
include_once 'includes/sub_kriteria.inc.php';

$pgn = new SubKriteria($db);

if (isset($_GET['sub_kriteria_id'])) {
    $subKriteriaId = $_GET['sub_kriteria_id'];
    $stmt = $pgn->readById($subKriteriaId);

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['bobot_subkriteria']; // Output the weight
    } else {
        echo "0"; // No result found
    }
} else {
    echo "0"; // Default weight if none selected
}
?>
