<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
session_start();
require '../layout_function.php';
if(!isset($_SESSION['username'])){
    header('location:../halaman_login.php?gagal');
}else if(!($_SESSION['stat'] == 'kasir')){
    echo"<script type='text/javascript'>
                setTimeout(function () {
                    swal({
                        title: 'Warning',
                        text: 'Anda Bukan Kasir !!!',
                        icon: 'warning',
                        timer: 3000,
                        button: false,
                    });
                }, 10);
                window.setTimeout(function () {
                    window.location.replace('../logout.php');
                }, 3000);
        </script>";
}


atas();
?>
<nav class="navbar navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" style="color:white;" class="form-inline"><img src="<?=$icon?>" alt="" style="width:30px;">
        <?= $label ?></a>
</nav>
<br><br><br>
<div class="row">
            <div class="col-3">
                <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action list-group-item-dark" id="list-settings-list"
                        href="halaman_transaksi.php" role="tab" aria-controls="settings">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        Home
                    </a>
                    <a class="list-group-item list-group-item-action list-group-item-dark" id="list-settings-list"
                        href="bayar.php" role="tab" aria-controls="settings">
                        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                        List Belum Bayar
                    </a>
                    <a class="list-group-item list-group-item-action list-group-item-dark" id="list-settings-list"
                        href="laporan_keuangan.php" role="tab" aria-controls="settings">
                        <i class="fa fa-calculator" aria-hidden="true"></i>
                        Laporan Transaksi
                    </a>
                    <a class="list-group-item list-group-item-action list-group-item-dark" id="list-settings-list"
                        href="../logout.php" role="tab" aria-controls="settings">
                        <i class="fa fa-power-off" aria-hidden="true"></i>
                        Keluar
                    </a>
                    <a class="list-group-item list-group-item-dark" id="list-settings-list" role="tab" aria-controls="settings"
                        style="height:372px;"></a>
                </div>
            </div>
            <div class="col-9 border bg-light" style="height:568px;">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-content" id="v-pills-tabContent">
                        <br>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">
                                <i class="fa fa-home" aria-hidden="true"></i>
                                Home
                                </li>
                            </ol>
                            <?php
                    date_default_timezone_set('Asia/Jakarta');
                    $b = time();
                    $hour = date("G", $b);
                    $pagi = "Selamat Pagi";
                    $siang = "Selamat Siang";
                    $sore = "Selamat Sore";
                    $malam = "Selamat Malam";
                    if($hour >=19 && $hour<=23){
                        echo "<h3>" . $malam . "</h3>";
                    }else if($hour>=0 && $hour<=11){
                        echo "<h3>" . $pagi . "</h3>";
                    }else if($hour >=15 && $hour<=17){
                        echo "<h3>" . $sore . "</h3>";
                    }else if($hour >=12 && $hour<=14){
                        echo "<h3>" . $siang . "</h3>";
                    }
                    ?>
                    <div class="jam-digital-malasngoding">
                        <div class="kotak">
                            <p id="jam"></p>
                        </div>
                        <div class="kotak">
                            <p id="menit"></p>
                        </div>
                        <div class="kotak">
                            <p id="detik"></p>
                        </div>
                    </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <script>
window.setTimeout("waktu()", 1000);
 
 function waktu() {
     var waktu = new Date();
     setTimeout("waktu()", 1000);
     document.getElementById("jam").innerHTML = waktu.getHours();
     document.getElementById("menit").innerHTML = waktu.getMinutes();
     document.getElementById("detik").innerHTML = waktu.getSeconds();
 }
</script>

<?php
bawah();
?>