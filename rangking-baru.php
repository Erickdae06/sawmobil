<?php
include_once 'header.php';
include_once 'includes/alternatif.inc.php';
$pgn1 = new Alternatif($db);
include_once 'includes/kriteria.inc.php';
$pgn2 = new Kriteria($db);
include_once 'includes/nilai.inc.php';
$pgn3 = new Nilai($db);
include_once 'includes/sub_kriteria.inc.php'; // Include SubKriteria

if ($_POST) {
    include_once 'includes/rangking.inc.php';
    $eks = new Rangking($db);
    
    $eks->ia = $_POST['ia'];
    $eks->ik = $_POST['ik'];
    $eks->sub_kriteria = $_POST['sub_kriteria'];
    $eks->nn = $_POST['nn'];

    if ($eks->insert()) {
        echo '<div class="alert alert-success">Berhasil Tambah Data!</div>';
    } else {
        echo '<div class="alert alert-danger">Gagal Tambah Data!</div>';
    }
}
?>

<div class="row">
    <div class="col-xs-12">
        <div class="well">
            <h3>Tambah Rangking</h3>
            <form method="post">
                <div class="form-group">
                    <label for="ia">Alternatif</label>
                    <select class="form-control" id="ia" name="ia">
                        <?php
                        $stmt3 = $pgn1->readAll();
                        while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row3['id_alternatif']}'>{$row3['nama_alternatif']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ik">Kriteria</label>
                    <select class="form-control" id="ik" name="ik" onchange="fetchSubCriteria(this.value)">
                        <?php
                        $stmt2 = $pgn2->readAll();
                        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row2['id_kriteria']}'>{$row2['nama_kriteria']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sub_kriteria">Sub Kriteria</label>
                    <select class="form-control" id="sub_kriteria" name="sub_kriteria" onchange="displayWeight(this.value)">
                        <option value="">Pilih Sub Kriteria</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="weight">Bobot Sub Kriteria</label>
                    <input type="text" class="form-control" id="weight" name="weight" readonly>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan Nilai</label>
                    <select class="form-control" id="keterangan" name="nn" disabled>
                        <option value="">Pilih Keterangan</option>
                        <option value="5">Sangat Tinggi</option>
                        <option value="4">Tinggi</option>
                        <option value="3">Cukup</option>
                        <option value="2">Rendah</option>
                        <option value="1">Sangat Rendah</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" onclick="location.href='rangking.php'" class="btn btn-success">Kembali</button>
            </form>
        </div>
    </div>
</div>

<script>
function fetchSubCriteria(kriteriaId) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_sub_kriteria.php?kriteria_id=" + kriteriaId, true);
    xhr.onload = function() {
        if (this.status === 200) {
            document.getElementById('sub_kriteria').innerHTML = this.responseText;
        }
    };
    xhr.send();
}

function displayWeight(subKriteriaId) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_weight.php?sub_kriteria_id=" + subKriteriaId, true);
    xhr.onload = function() {
        if (this.status === 200) {
            const weight = this.responseText;
            document.getElementById('weight').value = weight;
            updateKeterangan(weight); // Update the keterangan based on weight
        }
    };
    xhr.send();
}

function updateKeterangan(weight) {
    const keteranganSelect = document.getElementById('keterangan');
    for (let i = 0; i < keteranganSelect.options.length; i++) {
        if (keteranganSelect.options[i].value == weight) {
            keteranganSelect.selectedIndex = i;
            break;
        }
    }
}
</script>

<?php
include_once 'footer.php';
?>
