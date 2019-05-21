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
                            <i class="fa fa-calculator" aria-hidden="true"></i>
                            Laporan Transaksi
                        </li>
                    </ol>
                    <table class="table table-bordered table-sm">
                        <thead class="text-center">
                            <tr>
                                <th>
                                No Transaksi
                                </th>
                                <th>
                                Nama Kasir
                                </th>
                                <th>
                                Kode Pesanan
                                </th>
                                <th>
                                Pesanan
                                </th>
                                <th>
                                Total Bayar
                                </th>
                                <th>
                                Bayar
                                </th>
                                <th>
                                Kembalian
                                </th>
                                <th>
                                Tanggal
                                </th>
                            </tr>
                        </thead>
                        <?php
                        $query = mysqli_query($link, "SELECT * FROM transaksi INNER JOIN t_pegawai ON transaksi.nip=t_pegawai.nip GROUP BY no_transaksi");
                        while($data = mysqli_fetch_assoc($query)){
                        $kode_menu = $data['pesanan']
                        ?>
                        <tbody class="text-center">
                            <tr>
                                <td>
                                    <?= $data['no_transaksi'] ?>
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
                                $makanan = mysqli_query($link, "SELECT * FROM transaksi INNER JOIN menu ON transaksi.pesanan=menu.kode WHERE transaksi.pesanan='$kode_menu' GROUP BY transaksi.pesanan");
                                while($mak = mysqli_fetch_assoc($makanan)){
                                    echo"<li>"
                                        . $mak['nama'] .
                                        "</li>";
                                }
                                ?>
                                </ul>
                                </td>
                                <td>
                                    <?= $data['total_bayar'] ?>
                                </td>
                                <td>
                                    <?= $data['bayar'] ?>
                                </td>
                                <td>
                                    <?= $data['kembalian'] ?>
                                </td>
                                <td>
                                    <?= $data['tgl'] ?>
                                </td>
                            </tr>
                        </tbody>
                        <?php } ?>
                    </table>
                </nav>
            </div>
        </div>
    </div>
</div>

<?php
bawah();
?>