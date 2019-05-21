<?php
require '../layout_function.php';
$tahun = date('Y');
atas();
?>
<br>
<center>
    <h2>Dafta Menu Resto Kang Kabayan <?=$tahun?></h2>
</center>
<br>
<div class="container">
    <table class="table table-bordered">
        <thead class="text-center">
            <tr>
                <th>
                    Kode Menu
                </th>
                <th>
                    Nama Menu
                </th>
                <th>
                    Jenis Menu (Makanan/Minuman)
                </th>
                <th>
                    Harga
                </th>
            </tr>
        </thead>
        <?php
    $query = mysqli_query($link, "SELECT * FROM menu");
    while($data = mysqli_fetch_assoc($query)){
    ?>
        <tbody>
            <tr>
                <td class="text-center">
                    <?= $data['kode'] ?>
                </td>
                <td>
                    <?= ucwords($data['nama']) ?>
                </td>
                <td class="text-center">
                    <?= $data['jenis'] ?>
                </td>
                <td class="text-center">
                    <?= ucwords($data['harga']) ?>
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

<script>
    window.print();
</script>

<?php
bawah();
?>