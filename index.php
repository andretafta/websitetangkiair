<?php
//Simpan dengan nama file panel.php
require "koneksidb.php";

$start_date_error = '';
$end_date_error = '';

if (isset($_POST["export"])) {
    if (empty($_POST["start_date"])) {
        $start_date_error = '<div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Masukkan Tanggal Awal!</strong></div>';
    } else if (empty($_POST["end_date"])) {
        $end_date_error = '<div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Masukkan Tanggal Akhir!</strong></div>';
    } else {
        $file_name = 'Data.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Content-Type: application/csv;");

        $file = fopen('php://output', 'w');

        $header = array("tanggal", "waktu", "nilai");

        fputcsv($file, $header);

        $query = "
  SELECT DATE(waktu) AS tanggal, TIME(waktu) AS pukul, nilai FROM tabel_monitoring 
  WHERE DATE(waktu) >= '" . $_POST["start_date"] . "' 
  AND DATE(waktu) <= '" . $_POST["end_date"] . "' 
  ORDER BY waktu DESC
  ";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $data = array();
            $data[] = $row["tanggal"];
            $data[] = $row["pukul"];
            $data[] = $row["nilai"];
            fputcsv($file, $data);
        }
        fclose($file);
        exit;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
    </script>

    <script src="http://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/chart.bundle.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <script src="js/datepickers.js"></script>
    <title>Monitoring dan Kontrol Tangki Air</title>

</head>

<body class="bg-light">
    <center>
        <!-- <img class="img-fluid responsive-sm mt-3" src="img/png2.png" alt="Responsive image" style="width:480px; height:50px;"> -->
        <div class="container">
            <h2 class="mt-3 font-weight-bold">PANEL KONTROL DAN MONITORING TANGKI AIR</h2>
            <hr>
            <h5 class="font-weight-bold">KONTROL DAN STATUS</h5>
            <hr>
            <div class="row mt-4">
                <div class="col ">
                    <div class="card " style="max-width:25rem; height: 165px">
                        <h5 class="card-header bg-dark text-white font-weight-bold">Kontrol Pompa</h5>
                        <div class="card-body">
                            <a href="proses.php?channel=CH_1&state=0" class="btn btn-success btn-lg mt-2">ON</a>
                            <a href="proses.php?channel=CH_1&state=1" class="btn btn-danger btn-lg mt-2">OFF</a>
                        </div>
                    </div>
                </div>
                <div class="col status-pompa">
                </div>
            </div>
            <div class="load-monitor"></div>
            <div class="row mt-3">
                <div class="col">
                    <hr>
                    <h5 class="font-weight-bold">EXPORT DATA KE CSV</h5>
                    <hr>
                    <?php echo $start_date_error; ?>
                    <?php echo $end_date_error; ?>
                    <form method="post">
                        <div class="row input-daterange">
                            <div class="col">
                                <input type="text" name="start_date" class="form-control" placeholder="Tanggal Awal"
                                    readonly />
                            </div>
                            <div class="col">
                                <input type="text" name="end_date" class="form-control" placeholder="Tanggal Akhir"
                                    readonly />
                            </div>
                        </div>
                        <div class="col mt-3">
                            <input type="submit" name="export" value="Export Data" class="btn btn-info" />
                        </div>
                    </form>
                </div>
            </div>
            <div class='load-grafik'></div>
            <div class='load-tabel'></div>

        </div>

        <footer class="py-3">
            <div class="container">
                <p class="m-0 text-center">Copyright &copy; 2020 SMP IDN Boarding School</p>
            </div>
        </footer>
    </center>


    </div>

    <script>
    $(document).ready(function() {
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 4000);
        $('.input-daterange').datepicker({
            todayBtn: 'linked',
            format: "yyyy-mm-dd",
            autoclose: true
        });
        setInterval(function() {
            $('.status-pompa').load("status.php")
        }, 3000);
        setInterval(function() {
            $('.load-monitor').load("kontrol.php")
        }, 3000);
        setInterval(function() {
            $('.load-grafik').load("data-grafik.php")
        }, 3000);
        setInterval(function() {
            $('.load-tabel').load("data-tabel.php")
        }, 3000);
    });
    </script>

    <!-- Sweet Alert -->
    <script src="js/sweetalert2.all.min.js"></script>

</body>

</html>