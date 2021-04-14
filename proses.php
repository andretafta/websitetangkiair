<?php

//Simpan dengan nama file proses.php
require "koneksidb.php";

$data = query("SELECT * FROM tabel_kontrol")[0];

if (isset($_GET['channel']) && isset($_GET['state'])) {
	$channel = $_GET['channel'];
	$state   = $_GET['state'];
	if ($channel == 'CH_1') {
		$sql = "UPDATE tabel_kontrol SET CH_1 = '$state'";
	} else if ($channel == 'CH_2') {
		$sql = "UPDATE tabel_kontrol SET CH_2 = '$state'";
	}
	$koneksi->query($sql);
	header('Location:index.php');
}

$result  = json_encode($data);
echo $result;