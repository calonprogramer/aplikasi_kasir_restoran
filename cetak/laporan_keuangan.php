<?php 
require '../layout_function.php';

atas();
?>

<?php
if ( isset($_POST['dt1']) && isset($_POST['dt2']) ) {
    $dt1 = $_POST['dt1'];
    $dt2 = $_POST['dt2'];
    $judul = "(Dari ". $dt1 . " Sampai " . $dt2 . ")";

    $query = mysqli_query($link, "SELECT * FROM transaksi INNER JOIN t_pegawai ON transaksi.nip=t_pegawai.nip WHERE transaksi.tgl BETWEEN '$dt1' AND '$dt2' GROUP BY no_transaksi");

    $totalPendapatan = mysqli_query($link, "SELECT SUM(total_bayar) as pend FROM (SELECT total_bayar FROM transaksi WHERE transaksi.tgl BETWEEN '$dt1' AND '$dt2' GROUP BY no_transaksi) AS tr");
    $hasil = mysqli_fetch_assoc($totalPendapatan);
}

if ( empty($_POST['dt1']) && empty($_POST['dt2']) ) {
    $judul = "(Semua Transaksi)";
    $query = mysqli_query($link, "SELECT * FROM transaksi INNER JOIN t_pegawai ON transaksi.nip=t_pegawai.nip GROUP BY no_transaksi");
}
?>

<div class="container">

<center>
    <h1 class="mt-3">Laporan Keuangan</h1>
    <h3><?= $judul ?></h3>
</center>

<table class="table table-bordered table-sm mt-3">
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
        </tr>
    </thead>
    <?php
        while($data = mysqli_fetch_assoc($query)){
        $no_meja = $data['no_meja'];
        $kode_menu = $data['pesanan'];
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
                        $makanan = mysqli_query($link, "SELECT * FROM transaksi INNER JOIN menu ON transaksi.pesanan=menu.kode WHERE transaksi.no_meja='$no_meja' GROUP BY transaksi.pesanan");
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
        </tr>
    </tbody>
    <?php } ?>
</table>

<h3>Total Pendapatan = <?php
$format_indonesia = number_format ($hasil['pend'], 2, ',', '.');
echo "Rp. " . $format_indonesia;
?></h3>

<script>
		window.print();
	</script>

</div>


<?php
JS();
bawah();
?>