<?php
require '../layout_function.php';
$tahun = date('Y');
atas();
?>
<br>
<center>
    <h2>Data Transaksi Vixma Group Cafe <?=$tahun?></h2>
    <h3></h3>
</center>
<br>
<div class="container">
    <table class="table table-bordered">
        <thead class="text-center">
            <tr>
                <th>
                    Nomor Induk Pegawai
                </th>
                <th>
                    Nama Pegawai
                </th>
                <th>
                    Jenis Kelamin
                </th>
                <th>
                    Jabatan
                </th>
            </tr>
        </thead>
        <?php
    $query = mysqli_query($link, "SELECT * FROM t_pegawai");
    while($data = mysqli_fetch_assoc($query)){
    ?>
        <tbody>
            <tr>
                <td class="text-center">
                    <?= $data['nip'] ?>
                </td>
                <td>
                    <?= ucwords($data['nama']) ?>
                </td>
                <td class="text-center">
                    <?= $data['jk'] ?>
                </td>
                <td class="text-center">
                    <?= ucwords($data['jabatan']) ?>
                </td>
            </tr>
        </tbody>
        <?php } ?>
    </table>
    <div class="row">
        <div class="col text-right">
            Vixma_Group_<?=$tahun?>
        </div>
    </div>
</div>

<!-- <script>
    window.print();
</script> -->

<?php
bawah();
?>