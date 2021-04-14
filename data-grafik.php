<?php
//Simpan dengan nama file panel.php
require "koneksidb.php";
$data = query("SELECT * FROM tabel_kontrol")[0];
$data1 = query("SELECT * FROM tabel_monitoring ORDER BY id DESC")[0];
$data3 = mysqli_query($koneksi, "SELECT TIME(waktu) as pukul, nilai FROM (SELECT * FROM tabel_monitoring ORDER BY id DESC LIMIT 6) as Test ORDER BY id ASC LIMIT 6");

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
    <div class="row mt-2">
        <div class="col" style="width: 700px;">
            <hr>
            <h5 class=" font-weight-bold">GRAFIK KETINGGIAN AIR</h5>
            <hr>
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <script>
        // $(document).ready(function() {
        //     $('#myTable').DataTable({
        //         "order": [
        //             [0, "desc"]
        //         ]
        //     });
        // });


        var linechart = document.getElementById('myChart');
        var myChart = new Chart(linechart, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($data_tanggal); ?>, // Merubah data tanggal menjadi format JSON
                datasets: [{
                    label: ' Data Ketinggian',
                    data: <?php echo json_encode($data_jarak); ?>,
                    borderColor: 'rgba(255,99,132,1)',
                    backgroundColor: 'transparent',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    xAxes: [{
                        ticks: {
                            display: true,
                            autoSkip: true,
                            maxTicksLimit: 6
                        }
                    }]
                },
                tooltips: {
                    mode: 'index'
                }
            }
        });
    </script>
</body>

</html>