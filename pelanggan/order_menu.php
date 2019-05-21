<?php
session_start();
require '../layout_function.php';
$no_meja = $_SESSION['no_meja'];

// FUNGSI
Function tombol(){
    global $link;
    global $no_meja;
  
    $query = mysqli_query($link, "SELECT * FROM sementara WHERE no_meja='$no_meja'");
    $cek = mysqli_num_rows($query);
  
    if($cek == 0){
      echo 'disabled';
    }else{
      echo 'enable';
    }
  }

// AKHIR

atas();

if(isset($_POST['submit'])){
    if(sementara($_POST) > 0){
        echo 'Data Berhasil';
    }else{
        echo "Gagal Ditambahkan";
    }
}
?>
<style>
    .scroll {
        width: 100%;
        background: #C0C0C0;
        padding: 10px;
        overflow: scroll;
        height: 580px;

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
        <a href="../logout.php?stat=<?= $no_meja ?>"><img src="https://kucingkampung27.files.wordpress.com/2011/03/shutdown4.png" alt="" style="width:30px;"></a>
</nav>

<br><br><br>

<div class="container-fluid">
    <div class="row">
        <div class="col-9">
            <div class="scroll">
                <div class="alert alert-primary" role="alert">
                    <b>Makanan</b>
                </div>
                <div class="row">
                    <?php
            $query = mysqli_query($link,"SELECT * FROM menu where jenis='makanan'");
            while($data = mysqli_fetch_assoc($query)){
            ?>
                    <div class="col-4">
                        <br>
                        <div class="card" style="width: 18rem;">
                            <img src="<?= "../gambar/" . $data['foto'] ?>" class="card-img-top" alt="..." style="height:170px;">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?= $data['nama'] ?>
                                </h5>
                                RP. <?= $data['harga'] ?><br>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal" data-whatever="Kelola Pesanan!"
                                    data-nama="<?= $data['nama'] ?>" data-kode="<?= $data['kode'] ?>" data-meja="<?= $no_meja ?>">Pesan</button>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <br>
                <div class="alert alert-primary" role="alert">
                    <b>Minumam</b>
                </div>
                <div class="row">
                    <?php
                    $minuman = "minuman";
                    $query = mysqli_query($link,"SELECT * FROM menu where jenis='$minuman'");
                    while($data = mysqli_fetch_assoc($query)){
                    ?>
                    <div class="col-4">
                        <br>
                        <div class="card" style="width: 18rem;">
                            <img src="../gambar/<?= $data['foto'] ?>" class="card-img-top" alt="..." style="height:170px;">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?= $data['nama'] ?>
                                </h5>
                                RP. <?= $data['harga'] ?><br>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal" data-whatever="Kelola Pesanan!"
                                    data-nama="<?= $data['nama'] ?>" data-kode="<?= $data['kode'] ?>" data-meja="<?= $no_meja ?>">Pesan</button>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col border">
            <br>
            <center><b>PESANAN!</b></center>
            <form action="proses.php" method="post" name="autoSumForm">
                <table class="table table-sm bordered" width="100%">
                    <thead>
                        <tr>
                            <th>
                                Nama Menu
                            </th>
                            <th>
                                Qty
                            </th>
                            <th>
                                Harga
                            </th>
                            <th colspan="2">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($link, "SELECT * From sementara WHERE no_meja='$no_meja'");
                        while($data = mysqli_fetch_assoc($query)){
                        ?>
                        <tr>
                            <td>
                                <?= $data['nama'] ?>
                            </td>
                            <td>
                                <?= $data['jumlah'] ?>
                            </td>
                            <td>
                                <?= $data['harga'] ?>
                            </td>
                            <td>
                                <?= $data['total'] ?>
                            </td>
                            <td>
                                <a href="proses.php?id=<?= $data['kode'];?>">-</a>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="4">
                                Total Bayar :
                            </td>
                            <td>
                            <?php
                            $query = mysqli_query($link, "SELECT SUM(total) as total_bayar from sementara WHERE no_meja='$no_meja'");
                            $total = mysqli_fetch_assoc($query);
                            echo $total['total_bayar'];
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <a href="proses.php?no=<?= $no_meja ?>">Reset Pesanan</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- <table class="table table-sm">
                    <tr>
                        <td>
                            Bayar :
                        </td>
                        <td>
                            <input type="text" name="bayar" id="bayar" class="form-control form-control-sm"
                                onFocus="startCalc();" onBlur="stopCalc();" onkeypress="return hanyaAngka(event)" required autocomplete="off">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Kembalian :
                        </td>
                        <td>
                            <input type="text" value="<?php total_bayar(); ?>" name="total" id="total"
                                onFocus="startCalc();" onBlur="stopCalc();" hidden>
                            <input type="text" name="kembali" id="kembali" class="form-control form-control-sm" readonly
                                onchange="tryNumberFormat(this.form.thirdBox);" value=0>
                        </td>
                    </tr>
                </table> -->
                <button type="button" class="btn btn-primary btn-sm form-control" data-toggle="modal" data-target="#order"
                    data-whatever="Masukan Nama!" data-meja="<?= $no_meja ?>" <?php tombol() ?> >ORDER!</button>
            </form>
        </div>
    </div>
</div>

<!-- Khusus Modal -->
<!-- Modal Pemesanan Data Makanan-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm" id="kode" name="kode" hidden>
                        <label for="recipient-name" class="col-form-label">Nama Menu :</label>
                        <input type="text" class="form-control form-control-sm" id="nama" name="nama" disabled>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Qty :</label>
                        <input type="text" class="form-control form-control-sm" id="qty" name="qty"
                            onkeypress="return hanyaAngka(event)" required autocomplete="off">
                        <input type="text" class="form-control form-control-sm" id="mejaa" name="meja" autocomplete="off" hidden>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Tambah</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!-- Modal Order -->
<div class="modal fade" id="order" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="proses.php" method="post">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nama Costumer :</label>
                        <input type="text" class="form-control form-control-sm" id="nama" name="nama" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">No. Meja :</label>
                        <input type="text" class="form-control form-control-sm" id="meja" name="meja" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm" type="submit" name="order"
                            id="order">LANJUTKAN MEMESAN!</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>


<?php
JS();
?>

<!-- Khusus JS -->
<script type="text/JavaScript">
// Pesan
    $('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var recipient = button.data('whatever');
    var nama = button.data('nama');
    var kode = button.data('kode');
    var meja = button.data('meja');
    var modal = $(this);
    modal.find('.modal-title').text(recipient);
    modal.find('.modal-body #nama').val(nama);
    modal.find('.modal-body #kode').val(kode);
    modal.find('.modal-body #mejaa').val(meja);
})

// Order
$('#order').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var recipient = button.data('whatever');
    var nama = button.data('nama');
    var kode = button.data('kode');
    var meja = button.data('meja');
    var modal = $(this);
    modal.find('.modal-title').text(recipient);
    modal.find('.modal-body #nama').val(nama);
    modal.find('.modal-body #kode').val(kode);
})

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