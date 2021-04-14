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