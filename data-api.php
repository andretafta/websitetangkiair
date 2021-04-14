<?php
require "koneksidb.php";
$nilai  = $_GET["nilai"];

define ('BOT_TOKEN', '1306673125:AAGdf--aBaYXdrULK7BOlflebJ6ptO-479Y');
define ('CHAT_ID', '766134625');

function kirimTelegram($pesan)
{
    $pesan = json_encode($pesan);
    $API = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendmessage?chat_id=" . CHAT_ID . "&text=$pesan";
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt ($ch, CURLOPT_URL, $API);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


// $data = query("SELECT * FROM tabel_monitoring")[0]; 	 
if ($nilai >= 100) {
    $sql1 = "UPDATE tabel_kontrol SET CH_1 = '0'";
    $koneksi->query($sql1);
    $a = "Status Tangki Air Kosong ";
    $a .= "dan Pompa Menyala";
    kirimTelegram($a);
    
} else if ($nilai <= 30) {
    $sql1 = "UPDATE tabel_kontrol SET CH_1 = '1'";
    $koneksi->query($sql1);
   $a = "Status Tangki Air Penuh ";
   $a .= "dan Pompa Mati";
   kirimTelegram($a);

}

$sql      = "INSERT INTO tabel_monitoring(nilai) VALUES ('$nilai')";
$koneksi->query($sql);
$response = query("SELECT * FROM tabel_monitoring ORDER BY id DESC")[0];

$result = json_encode($response);
echo $result;
?>