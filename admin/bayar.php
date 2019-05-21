<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
session_start();
require '../layout_function.php';
$username = $_SESSION['username'];
$ambil_data = mysqli_query($link, "SELECT * FROM login INNER JOIN t_pegawai ON login.id=t_pegawai.nip WHERE username='$username' ");
$data = mysqli_fetch_assoc($ambil_data);
$kasir = $data['nama'];
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
                }, 3000);m
        </script>";
}

if(isset($_POST['kembali'])){
    $no = $_POST['no'];
    $nama = $_POST['nama'];
    $no_meja = $_POST['meja'];
    $bayar = $_POST['bayar'];
    $tot = $_POST['total'];
    $kembali = $_POST['kembalian'];
    $tgl = date('Y-m-d');
    $no_transaksi = $tgl.'-'.$no;

    $queryNip = mysqli_query($link, "SELECT * FROM t_pegawai WHERE nama='$nama'");
    $dataNip = mysqli_fetch_assoc($queryNip);
    $nip = $dataNip['nip'];

    $queryPesanan = mysqli_query($link, "SELECT * FROM pesan WHERE no_meja='$no_meja'");
    while($dataPesanan = mysqli_fetch_assoc($queryPesanan)){
    $pesanan = $dataPesanan['kode'];

    $query = mysqli_query($link, "INSERT INTO transaksi VALUES ('','$no_transaksi','$nip','$no_meja','$pesanan','$tot','$bayar','$kembali','$tgl')");
    if(isset($_POST['kembali'])){
        mysqli_query($link, "DELETE FROM pesan WHERE no_meja='$no_meja'");
        echo "
        <script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Selamat',
                    text: 'Transaksi Berhasil',
                    icon: 'success',
                    timer: 3000,
                    button: false,
                });
            }, 10);
            window.setTimeout(function () {
                window.location.replace('bayar.php');
            }, 3000); 
        </script>
        ";
    }else{
        echo "Transaksi Gagal";
    }

    }
}

atas();
?>
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
                href="halaman_admin.php" role="tab" aria-controls="settings">
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
                            List Belum Bayar
                        </li>
                    </ol>

                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr class="text-center">
                                <th width="80px">
                                    Kode Pesanan
                                </th>
                                <th>
                                    Nama Pemesan
                                </th>
                                <th>
                                    No Meja
                                </th>
                                <th>
                                    List Pesanan
                                </th>
                                <th>
                                    Total Bayar
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        $query = mysqli_query($link, "SELECT * FROM pesan GROUP BY no_meja");
                        while($data = mysqli_fetch_assoc($query)){
                        $meja = $data['no_meja'];
                        ?>
                            <tr>
                                <td class="text-center">
                                    <?= $meja ?>
                                </td>
                                <td>
                                    <?= $data['nama'] ?>
                                </td>
                                <td>
                                    <?= $data['no_meja'] ?>
                                </td>
                                <td>
                                    <ul>
                                        <?php
                                $makanan = mysqli_query($link, "SELECT * FROM pesan INNER JOIN menu ON pesan.kode=menu.kode WHERE no_meja='$meja' GROUP BY pesan.kode");
                                while($mak = mysqli_fetch_assoc($makanan)){
                                    echo"<li>"
                                        . $mak['nama'] .
                                        "</li>";
                                }
                                ?>
                                    </ul>
                                </td>
                                <td class="text-center">
                                    <?php
                                $total = mysqli_query($link, "SELECT SUM(total) as tagihan FROM pesan WHERE no_meja='$meja'");
                                $tagihan = mysqli_fetch_assoc($total);
                                echo "Rp. " . $tagihan['tagihan'];
                                ?>
                                </td>
                                <td class="text-center">
                                    <a href="halaman_proses.php?meja=<?=$meja?>"
                                        class="btn btn-sm btn-primary form-control">
                                        <font color="white">BAYAR!</font>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </nav>
            </div>
        </div>
    </div>
</div>

<?php
JS();
?>

<script type="text/JavaScript">

    function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))

        return false;
    return true;
}

</script>

<?php
bawah();
?>