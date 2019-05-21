<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
session_start();
require '../layout_function.php';
if(!isset($_SESSION['username'])){
    header('location:../halaman_login.php?gagal');
}else if(!($_SESSION['stat'] == 'admin')){
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
$username = $_SESSION['username'];
$ambil_data = mysqli_query($link, "SELECT * FROM login INNER JOIN t_pegawai ON login.id=t_pegawai.nip WHERE username='$username' ");
$dat = mysqli_fetch_assoc($ambil_data);

$meja = $_GET['meja'];
$query = mysqli_query($link, "SELECT * FROM pesan WHERE no_meja='$meja'");
$data = mysqli_fetch_assoc($query);

atas();
?>

<style>
    .scroll {
        width: 100%;
        background: #C0C0C0;
        padding: 10px;
        overflow: scroll;
        height: 470px;

        /*script tambahan khusus untuk IE */
        scrollbar-face-color: #CE7E00;
        scrollbar-shadow-color: #FFFFFF;
        scrollbar-highlight-color: #6F4709;
        scrollbar-3dlight-color: #11111;
        scrollbar-darkshadow-color: #6F4709;
        scrollbar-track-color: #FFE8C1;
        scrollbar-arrow-color: #6F4709;
    }
</style>


<nav class="navbar navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" style="color:white;" class="form-inline"><img src="<?=$icon?>" alt="" style="width:30px;">
    <?= $label ?></a>
        <ul>
            <li>
            
            </li>
        </ul>
        <a href="../pelanggan/order_menu_admin.php" class="btn btn-sm btn-primary">Order Menu</a>
</nav>
<br><br><br>
<div class="row">
    <div class="col-3">
        <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action list-group-item-dark" id="list-settings-list"
                href="halaman_admin.php" role="tab" aria-controls="settings" disabled>
                <i class="fa fa-home" aria-hidden="true"></i>
                Home
            </a>
            <a class="list-group-item list-group-item-action list-group-item-dark" id="list-settings-list"
                href="kelola_data_pegawai.php" role="tab" aria-controls="settings">
                <i class="fa fa-address-card" aria-hidden="true"></i>
                Kelola Data Pegawai
            </a>
            <a class="list-group-item list-group-item-action list-group-item-dark" id="list-settings-list"
                href="kelola_menu.php" role="tab" aria-controls="settings">
                <i class="fa fa-beer" aria-hidden="true"></i>
                Kelola Data Menu
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
                style="height:274px;"></a>
        </div>
    </div>
    <div class="col-9 border bg-light" style="height:568px;">
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-content" id="v-pills-tabContent">
                <br>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                            <a href="bayar.php" style="text-decoration:none">List Belum Bayar</a> / Bayar
                        </li>
                    </ol>
                    <div class="scroll">
                        <div class="container">
                            <div class="row">
                                <div class="col-5 border">
                                    <center>
                                        <h3>RESTO KANG KABAYAN</h3>
                                        <h5>082218735557</h5>
                                        <font size="2px">Babakan Hurip Rt.002 Rw.003 Kel. Kota Kaler Sumedang Utara
                                        </font>
                                    </center>
                                    <br>
                                    <?php
                                    $queryAmbilData = mysqli_query($link, "SELECT MAX(no_transaksi) as noTrans FROM transaksi");
                                    $dataId = mysqli_fetch_assoc($queryAmbilData);
                                    $ambilId = $dataId['noTrans'];
                                    $pisah = substr($ambilId, -1);

                                    if($pisah > 0){
                                        $idTerambil = $pisah + 1;
                                    }else{
                                        $idTerambil = 1;
                                    }
                                    ?>
                                    <?= $idTerambil ?><br>
                                    Kasir : <?= $dat['nama'] ?> <br>
                                    No Meja : <?= $meja ?>
                                    <hr>
                                    <form action="proses.php" method="POST" name="autoSumForm">
                                        <input type="text" name="nama" value="<?= $dat['nama'] ?>" hidden>
                                        <input type="text" name="no_meja" value="<?= $meja ?>" hidden>
                                        <input type="text" value="<?=$idTerambil?>" name="no" hidden>
                                        <table style="width:100%;">
                                            <?php 
                                            $makanan = mysqli_query($link, "SELECT * FROM pesan INNER JOIN menu ON pesan.kode=menu.kode WHERE no_meja='$meja' GROUP BY pesan.kode");
                                            while($mak = mysqli_fetch_assoc($makanan)){
                                            ?>
                                            <tr class="row">
                                                <td class="col-6 text-left">
                                                    <?php echo $mak['nama']; ?>
                                                </td>
                                                <td class="col-2 text-center">
                                                    <?= $mak['jumlah'] ?>
                                                </td>
                                                <td class="col text-right">
                                                    <?php
                                                $format_indonesia = number_format ($mak['total'], 2, ',', '.');
                                                echo "Rp. " . $format_indonesia;
                                                ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </table>
                                        <hr>
                                        <table width="100%">
                                            <tr>
                                                <td>
                                                    Total Bayar :
                                                </td>
                                                <td class="text-right">
                                                    <?php
                                                $total = mysqli_query($link, "SELECT SUM(total) as total FROM pesan WHERE no_meja='$meja'");
                                                $tot = mysqli_fetch_assoc($total);
                                                ?>
                                                    <input type="text" value="<?php echo $tot['total'] ?>" name="total"
                                                        id="total" onFocus="startCalc();" onBlur="stopCalc();" hidden>
                                                    <?php
                                                $format_indonesia = number_format ($tot['total'], 2, ',', '.');
                                                echo "Rp. " . $format_indonesia;
                                                ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Bayar :
                                                </td>
                                                <td class="text-right">
                                                    Rp. <input type="text" name="bayar" id="bayar" class="text-right"
                                                        onFocus="startCalc();" onBlur="stopCalc();"
                                                        onkeypress="return hanyaAngka(event)" required
                                                        autocomplete="off">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Kembalian :
                                                </td>
                                                <td class="text-right">
                                                    <?php
                                                $format_indonesia = number_format ('30000', 2, ',', '.');
                                                ?>
                                                    Rp. <input class="text-right" type="text" name="kembali"
                                                        id="kembali" readonly
                                                        onchange="tryNumberFormat(this.form.thirdBox);" value=0>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-right">
                                                    <br>
                                                    <?= date('Y-m-d'); ?>
                                                    <br>
                                                </td>
                                            </tr>
                                        </table>
                                        <button type="submit">Cetak</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </nav>
        </div>
    </div>
</div>
</div>

<?php
JS();
?>

<script>
    function hanyaAngka(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))

            return false;
        return true;
    }

    function startCalc() {
        interval = setInterval("calc()", 1);
    }

    function calc() {
        two = document.autoSumForm.bayar.value;
        three = document.autoSumForm.total.value;
        document.autoSumForm.kembali.value = (two * 1) - (three * 1);
    }

    function stopCalc() {
        clearInterval(interval);
    }
</script>

<?php
bawah();
?>