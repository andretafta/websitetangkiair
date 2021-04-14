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
    <div class="row mt-4">
        <div class="col">
            <hr>
            <h5 class="font-weight-bold">TABEL KETINGGIAN AIR</h5>
            <hr>
            <table class="table text-center" id="myTable">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Nilai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data2 = mysqli_query($koneksi, "SELECT DATE(waktu) AS tanggal, TIME(waktu) AS pukul, nilai FROM tabel_monitoring ORDER BY waktu DESC LIMIT 10");
                    while ($row = mysqli_fetch_array($data2)) {
                        if ($row["nilai"] >= "100") {
                    ?>
                    <tr>
                        <td class="table-danger font-weight-bold"><?php echo $row['tanggal'] ?></td>
                        <td class="table-danger font-weight-bold"><?php echo $row['pukul'] ?></td>
                        <td class="table-danger font-weight-bold"><?php echo $row['nilai'] ?></td>
                        <td class="table-danger font-weight-bold"><?php echo "HABIS" ?></td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                        <td class="table-success font-weight-bold"><?php echo $row['tanggal'] ?></td>
                        <td class="table-success font-weight-bold"><?php echo $row['pukul'] ?></td>
                        <td class="table-success font-weight-bold"><?php echo $row['nilai'] ?></td>
                        <td class="table-success font-weight-bold"><?php echo "AMAN" ?></td>
                    </tr>
                    <?php }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "searching": false,
            "ordering": false,
            "lengthChange": false,
            "scrollY": '50vh',
            "scrollCollapse": true,
            "paging": false,
            "info": false,
            "order": [
                [0, "desc"]
            ]
        });
    });
    </script>
</body>

</html>