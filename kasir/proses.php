<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
session_start();
require '../layout_function.php';

$no = $_POST['no'];
$nama = $_POST['nama'];
$no_meja = $_POST['no_meja'];
$bayar = $_POST['bayar'];
$tot = $_POST['total'];
$kembali = $_POST['kembali'];
$tgl = date('d/m/Y h:i:s');
$no_transaksi = $tgl.'-'.$no;

$queryNip = mysqli_query($link, "SELECT * FROM t_pegawai WHERE nama='$nama'");
$dataNip = mysqli_fetch_assoc($queryNip);
$nip = $dataNip['nip'];

$username = $_SESSION['username'];
$ambil_data = mysqli_query($link, "SELECT * FROM login INNER JOIN t_pegawai ON login.id=t_pegawai.nip WHERE username='$username' ");
$dat = mysqli_fetch_assoc($ambil_data);

$query = mysqli_query($link, "SELECT * FROM pesan WHERE no_meja='$no_meja'");
$data = mysqli_fetch_assoc($query);

atas();
?>
<br>
<form action="bayar.php" method="post">
<div class="row">
    <div class="col-5 border">
        <center>
            <h3><?= $label ?></h3>
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
        No Meja : <?= $no ?>
        <hr>
        <input type="text" name="nama" value="<?= $dat['nama'] ?>" hidden>
        <input type="text" name="no_meja" value="<?= $meja ?>" hidden>
        <input type="text" value="<?=$idTerambil?>" name="no" hidden>
        <table style="width:100%;">
            <?php 
                $makanan = mysqli_query($link, "SELECT * FROM pesan INNER JOIN menu ON pesan.kode=menu.kode WHERE no_meja='$no_meja' GROUP BY pesan.kode");
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
                                                $total = mysqli_query($link, "SELECT SUM(total) as total FROM pesan WHERE no_meja='$no_meja'");
                                                $tot = mysqli_fetch_assoc($total);
                                                ?>
                    <input type="text" value="<?php echo $tot['total'] ?>" name="total" id="total"
                        onFocus="startCalc();" onBlur="stopCalc();" hidden>
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
                    <input type="text" name="bayar" id="bayar" value="<?= $bayar ?>" hidden>
                    <?php $format_indonesia = number_format ($bayar, 2, ',', '.');
                        echo "Rp. " . $format_indonesia; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Kembalian :
                </td>
                <td class="text-right">
                <input type="text" name="kembalian" value="<?= $kembali ?>" hidden>
                <?php $format_indonesia = number_format ($kembali, 2, ',', '.');
                        echo "Rp. " . $format_indonesia; ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-right">
                    <br>
                    <?= date('d/m/Y h:i:s'); ?>
                    <br>
                </td>
            </tr>
        </table>
    </div>
</div>
<br><br>
    <input type="text" name="meja" value="<?= $no_meja ?>" hidden>
    <button type="submit" name="kembali">Kembali</button>
</form>

<?php
JS();
?>

<script>
    window.print();
</script>