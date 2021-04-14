<?php

define('BOT_TOKEN', '1332602499:AAF4Jegb2gbR4E4QDVNQgEu4rtk8IonK3MY');
define('CHAT_ID', '766134625');

function kirimTelegram($pesan)
{
    $pesan = json_encode($pesan);
    $API = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendmessage?chat_id=" . CHAT_ID . "&text=$pesan";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_URL, $API);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

$a = "Status Tangki Air Kosong ";
$a .= "dan Pompa Menyala";
kirimTelegram($a);