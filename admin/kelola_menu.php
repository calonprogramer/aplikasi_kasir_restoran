<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
session_start();
require '../layout_function.php';
if(!isset($_SESSION['username'])){
    header('location:../halaman_login.php');
}else if(!($_SESSION['stat'] == 'admin')){
    echo"<script type='text/javascript'>
                setTimeout(function () {
                    swal({
                        title: 'Warning',
                        text: 'Anda Bukan Admin !!!',
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

// proses tambah data
if(isset($_POST['upload'])){

    $nama_makanan = $_POST['nama'];
    $jenis = strtolower($_POST['jenis']);
    $harga = $_POST['harga'];

    $queryKode = mysqli_query($link, "SELECT MAX(kode) as kode_menu FROM menu");
    $cekKode = mysqli_num_rows($queryKode);
    if($cekKode > 0){
        $ambilKode = mysqli_fetch_assoc($queryKode);
        $oldkode = $ambilKode['kode_menu'];
        $akhir = substr($oldkode, 5);
        $kodeBaru = $akhir + 1;
        $newKode = "MENU-".sprintf("%03s", $kodeBaru);
    }else{
        $newKode = "MENU-001";
    }

    // gambar
    $ekstensi_diperbolehkan	= array('png','jpg');
    $nama = $_FILES['foto']['name'];
	$x = explode('.', $nama);
	$ekstensi = strtolower(end($x));
	$ukuran	= $_FILES['foto']['size'];
    $file_tmp = $_FILES['foto']['tmp_name'];
    $nama_foto = $nama_makanan . "." . $ekstensi;
    $target_file = '../gambar/'.$nama_foto;
    // sampai sini

    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
        if($ukuran < 2044070){			
        move_uploaded_file($file_tmp, $target_file);
        $query = mysqli_query($link, "INSERT INTO menu VALUES('$newKode','$nama_makanan','$jenis','$harga','$nama_foto')");
        if($query){
            echo "
            <script type='text/javascript'>
                setTimeout(function () {
                    swal({
                        title: 'SUCCESS!',
                        text: 'Data Berhasil Ditambahkan',
                        icon: 'success',
                        timer: 3000,
                        button: false,
                    });
                }, 10);
                window.setTimeout(function () {
                    window.location.replace('kelola_menu.php');
                }, 3000); 
            </script>
            ";
        }else{
            echo "
            <script type='text/javascript'>
                setTimeout(function () {
                    swal({
                        title: 'WARNING!',
                        text: 'Data Gagal Ditambahkan',
                        icon: 'danger',
                        timer: 3000,
                        button: false,
                    });
                }, 10);
                window.setTimeout(function () {
                    window.location.replace('kelola_menu.php');
                }, 3000); 
            </script>
            ";
        }
        }else{
        echo 'UKURAN FILE TERLALU BESAR';
        }
    }else{
        echo "
            <script type='text/javascript'>
                setTimeout(function () {
                    swal({
                        title: 'WARNING!',
                        text: 'Ekstensi File Tidak Sesuai',
                        icon: 'danger',
                        timer: 3000,
                        button: false,
                    });
                }, 10);
                window.setTimeout(function () {
                    window.location.replace('kelola_menu.php');
                }, 3000); 
            </script>
            ";
    }
}
// akhir proses

// proses edit data
if(isset($_POST['edit'])){

    $nama_makanan = $_POST['nama'];
    $jenis = strtolower($_POST['jenis']);
    $harga = $_POST['harga'];
    $kode = $_POST['kode'];

    // gambar
    $ekstensi_diperbolehkan	= array('png','jpg');
    $nama = $_FILES['foto']['name'];
	$x = explode('.', $nama);
	$ekstensi = strtolower(end($x));
	$ukuran	= $_FILES['foto']['size'];
    $file_tmp = $_FILES['foto']['tmp_name'];
    $nama_foto = $nama_makanan . "." . $ekstensi;
    $target_file = '../gambar/'.$nama_foto;
    // sampai sini

    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
        if($ukuran < 2044070){			
        move_uploaded_file($file_tmp, $target_file);
        $query = mysqli_query($link, "UPDATE menu SET nama='$nama_makanan', jenis='$jenis', harga='$harga', foto='$nama_foto' WHERE kode='$kode' ");
        if($query){
            echo "
            <script type='text/javascript'>
                setTimeout(function () {
                    swal({
                        title: 'SUCCESS!',
                        text: 'Data Berhasil Ditambahkan',
                        icon: 'success',
                        timer: 3000,
                        button: false,
                    });
                }, 10);
                window.setTimeout(function () {
                    window.location.replace('kelola_menu.php');
                }, 3000); 
            </script>
            ";
        }else{
            echo "
            <script type='text/javascript'>
                setTimeout(function () {
                    swal({
                        title: 'WARNING!',
                        text: 'Data Gagal Ditambahkan',
                        icon: 'error',
                        timer: 3000,
                        button: false,
                    });
                }, 10);
                window.setTimeout(function () {
                    window.location.replace('kelola_menu.php');
                }, 3000); 
            </script>
            ";
        }
        }else{
        echo 'UKURAN FILE TERLALU BESAR';
        }
    }else{
        echo "
            <script type='text/javascript'>
                setTimeout(function () {
                    swal({
                        title: 'WARNING!',
                        text: 'Ekstensi File Tidak Sesuai',
                        icon: 'danger',
                        timer: 3000,
                        button: false,
                    });
                }, 10);
                window.setTimeout(function () {
                    window.location.replace('kelola_menu.php');
                }, 3000); 
            </script>
            ";
    }
}
// akhr proses

// proses Hapus Data
if(isset($_POST['hapus'])){
    $kode = $_POST['kode'];

    $query = mysqli_query($link, "DELETE from menu WHERE kode='$kode'");
    if($query){
        echo "
        <script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'SUCCESS!',
                    text: 'Data Berhasil Dihapus',
                    icon: 'success',
                    timer: 3000,
                    button: false,
                });
            }, 10);
            window.setTimeout(function () {
                window.location.replace('kelola_menu.php');
            }, 3000); 
        </script>
        ";
    }else{
        echo "
        <script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'WARNING!',
                    text: 'Data Gagal Dihapus',
                    icon: 'error',
                    timer: 3000,
                    button: false,
                });
            }, 10);
            window.setTimeout(function () {
                window.location.replace('kelola_menu.php');
            }, 3000); 
        </script>
        ";
    }
}
// Akhir

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
            <a class="list-group-item list-group-item-action list-group-item-dark" id="list-settings-list" href="kelola_menu.php"
                role="tab" aria-controls="settings">
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
                            <i class="fa fa-beer" aria-hidden="true"></i>
                            Kelola Data Menu
                        </li>
                    </ol>

                    <div class="row">
                        <div class="col">
                            <form method="get">
                                <table border="0" width="100%">
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Cari Data" name="cari" autocomplete="off">
                                        </td>
                                        <td width="10px">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-dark btn-sm">Refresh</button>
                                        </td>
                                        <td width="70%" align="right">
                                            <a style="width:148px;" type="button" class="btn btn-dark btn-sm"
                                                data-toggle="modal" data-target="#input_data"
                                                data-whatever="@mdo"><font color="white">Tambah
                                                Data</font></a>
                                            <a href="../cetak/data_menu.php" target="_blank" style="width:148px;" type="button" class="btn btn-success btn-sm">Cetak</a>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>

                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th width="250px">
                                    Kode Makanan
                                </th>
                                <th>
                                    Nama Makanan
                                </th>
                                <th>
                                    Jenis
                                </th>
                                <th>
                                    Harga
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <?php
                            $halaman = 8;
                            $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
                            $mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
                            $query = mysqli_query($link, "SELECT * FROM menu");
                            $total = mysqli_num_rows($query);
                            
                            
                            if(isset($_GET['cari'])){
                                $data = $_GET['cari'];
                                $queryCari = mysqli_query($link,"SELECT * FROM menu WHERE nama like '%".$data."%' OR harga like '%".$data."%'")or die(mysql_error);
                                $totDataCari = mysqli_num_rows($queryCari);
                                $pages = ceil($totDataCari/$halaman);
                                $jalankan = mysqli_query($link,"SELECT * FROM menu WHERE nama like '%".$data."%' OR harga like '%".$data."%' ORDER BY nama ASC LIMIT $mulai, $halaman")or die(mysql_error);
                            }else{
                                $jalankan = mysqli_query($link,"SELECT * FROM menu LIMIT $mulai, $halaman")or die(mysql_error);
                                $pages = ceil($total/$halaman);
                            }


                            while($data = mysqli_fetch_assoc($jalankan)){
                        ?>
                        <tbody>
                            <tr>
                                <td>
                                    <center><?= $data['kode'] ?></center>
                                </td>
                                <td>
                                    <?= $data['nama'] ?>
                                </td>
                                <td>
                                    <center><?= $data['jenis'] ?></center>
                                </td>
                                <td>
                                    <center><?= $data['harga'] ?></center>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit_data"
                                        data-nama="<?= $data['nama'] ?>" data-jenis="<?= $data['jenis'] ?>"
                                        data-harga="<?= $data['harga'] ?>" data-kode="<?= $data['kode'] ?>" data-gambar="<?= $data['foto'] ?>">Edit</button> | <button
                                        class="btn btn-sm btn-danger" data-toggle="modal" data-nama="<?= $data['nama'] ?>" data-target="#hapus_data" data-kode="<?= $data['kode'] ?>">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                        <?php } ?>
                    </table>
                    <table border="0" class="posisi">
                        <tr>
                            <td>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <?php for ($i=1; $i<=$pages ; $i++){ ?>
                                        <li class="page-item"><a class="page-link" href="?halaman=<?php echo $i; ?>">
                                                <font color="black">
                                                    <?php echo $i; ?>
                                                </font>
                                            </a></li>
                                        <?php } ?>
                                    </ul>
                                </nav>
                            </td>
                        </tr>
                    </table>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Modal Iput Data -->
<div class="modal fade" id="input_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="nama" class="col-form-label">Nama Menu :</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="nama" id="nama" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="jenis" class="col-form-label">Jenis :</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="jenis" id="jenis" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="harga" class="col-form-label">Harga :</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="harga" id="harga" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="foto" class="col-form-label">Foto :</label>
                            </div>
                            <div class="col">
                                <input type="file" class="form-control-file" name="foto" id="foto" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="upload" class="btn btn-primary">Tambah</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
            <div class="modal-footer">
            <i class="fa fa-copyright" aria-hidden="true"> 2019 Vixma Group</i>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Input Data -->

<!-- Modal Edit Data -->
<div class="modal fade" id="edit_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="kode" class="col-form-label">Kode :</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="kode" id="kode" readonly autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="nama" class="col-form-label">Nama Menu :</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="nama" id="nama" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="jenis" class="col-form-label">Jenis :</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="jenis" id="jenis" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="harga" class="col-form-label">Harga :</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="harga" id="harga" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="foto" class="col-form-label">Foto :</label>
                            </div>
                            <div class="col">
                                <input type="file" class="form-control-file" name="foto" id="foto" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="edit" class="btn btn-primary">Ubah</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
            <div class="modal-footer">
            <i class="fa fa-copyright" aria-hidden="true"> 2019 Vixma Group</i>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modal Edit Data -->

<!-- Modal Hapus Data Petugas -->
<div class="modal fade" id="hapus_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="kode" id="kode" hidden><br>
                        <b>Anda Akan Menghapus Data :
                            <u>
                                <font name="nama" id="nama">Irsyad</font>
                            </u></b>
                    </div>
                    <button type="submit" name="hapus" class="btn btn-primary">LANJUTKAN</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
            <div class="modal-footer">
                <i class="fa fa-copyright" aria-hidden="true"> 2019 Vixma Group</i>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modal -->

<?php
JS();
?>

<!-- JavaScript -->
<script>
    $('#edit_data').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('whatever');
        var kode = button.data('kode')
        var nama = button.data('nama')
        var jenis = button.data('jenis')
        var harga = button.data('harga')
        var gambar = button.data('gambar')
        var modal = $(this)
        modal.find('.modal-body input').val(recipient)
        modal.find('.modal-body #kode').val(kode)
        modal.find('.modal-body #nama').val(nama)
        modal.find('.modal-body #harga').val(harga)
        modal.find('.modal-body #jenis').val(jenis)
    })

    $('#hapus_data').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('whatever')
        var kode = button.data('kode')
        var nama = button.data('nama')
        var modal = $(this)
        modal.find('.modal-body input').val(recipient)
        modal.find('.modal-body #kode').val(kode)
        modal.find('.modal-body #nama').text(nama)
    })
</script>
<!-- Akhir JavaScript -->



<?php
bawah();
?>