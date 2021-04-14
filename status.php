<?php
//Simpan dengan nama file panel.php
require "koneksidb.php";
$data = query("SELECT * FROM tabel_kontrol")[0];
$data1 = query("SELECT * FROM tabel_monitoring ORDER BY id DESC")[0];
$data3 = mysqli_query($koneksi, "SELECT TIME(waktu) AS pukul, nilai FROM tabel_monitoring");

$data_tanggal = array();
$data_jarak = array();

while ($data4 = mysqli_fetch_array($data3)) {
    $data_tanggal[] = $data4['pukul']; // Memasukan tanggal ke dalam array
    $data_jarak[] = $data4['nilai']; // Memasukan total ke dalam array
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
    <div class="card" style="max-width:25rem; height: 165px">
        <h5 class="card-header bg-dark text-white font-weight-bold">Status Pompa</h5>
        <div class="card-body">
            <?php if ($data["CH_1"] == 1) { ?>
            <h3 class="font-weight-bold mt-3 text-danger">MATI</h3>
            <?php } else { ?>
            <h3 class="font-weight-bold mt-3 text-success">NYALA</h3>
            <?php } ?>
        </div>
    </div>
</body>

</html>