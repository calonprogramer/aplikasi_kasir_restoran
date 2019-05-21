<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
session_start();
require '../layout_function.php';
if(!isset($_SESSION['username'])){
    header('location:../halaman_login.php');
}else if(!($_SESSION['stat'] == 'owner')){
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

// Proses Input Data Pegawai
if(isset($_POST['tambah'])){
    $nama = strtolower($_POST['nama']);
    $jk = $_POST['l'];
    $waktu_lahir = $_POST['tgl_lahir'];
    $jabatan = strtolower($_POST['jabatan']);
    $tgl = date('d.m.Y');

    $queryCekData = mysqli_query($link, "SELECT MAX(nip) as unip FROM t_pegawai");
    $data = mysqli_fetch_assoc($queryCekData);
    $ambilnip = $data['unip'];
    $belakang = substr($ambilnip, "22") + 1;

    $nip = $tgl . "." . str_replace('-', '.', $waktu_lahir) . "." . $belakang;

    $query = mysqli_query($link, "INSERT INTO t_pegawai VALUES ('$nip','$nama','$jk','$jabatan')");
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
                window.location.replace('kelola_data_pegawai.php');
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
                window.location.replace('kelola_data_pegawai.php');
            }, 3000); 
        </script>
        ";
    }
    
}
// Akhir

// Proses Edit Data Pegawai
if(isset($_POST['ubah'])){
    $nip = $_POST['nip'];
    $nama = strtolower($_POST['nama']);
    $jk = $_POST['l'];
    $jabatan = strtolower($_POST['jabatan']);

    $query = mysqli_query($link, "UPDATE t_pegawai SET nama='$nama', jk='$jk', jabatan='$jabatan' WHERE nip='$nip' ");
    if($query){
        echo "
        <script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'SUCCESS!',
                    text: 'Data Berhasil Diubah',
                    icon: 'success',
                    timer: 3000,
                    button: false,
                });
            }, 10);
            window.setTimeout(function () {
                window.location.replace('kelola_data_pegawai.php');
            }, 3000); 
        </script>
        ";
    }else{
        echo "
        <script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'WARNING!',
                    text: 'Data Gagal Diubah',
                    icon: 'warning',
                    timer: 3000,
                    button: false,
                });
            }, 10);
            window.setTimeout(function () {
                window.location.replace('kelola_data_pegawai.php');
            }, 3000); 
        </script>
        ";
    }
}
// Akhir

// proses Hapus Data
if(isset($_POST['hapus'])){
    $nip = $_POST['nip'];

    $query = mysqli_query($link, "DELETE from t_pegawai WHERE nip='$nip'");
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
                window.location.replace('kelola_data_pegawai.php');
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
                    icon: 'warning',
                    timer: 3000,
                    button: false,
                });
            }, 10);
            window.setTimeout(function () {
                window.location.replace('kelola_data_pegawai.php');
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
                Data Pegawai
            </a>
            <a class="list-group-item list-group-item-action list-group-item-dark" id="list-settings-list"
                href="kelola_menu.php" role="tab" aria-controls="settings">
                <i class="fa fa-beer" aria-hidden="true"></i>
                Data Menu
            </a>
            <a class="list-group-item list-group-item-action list-group-item-dark" id="list-settings-list"
                href="laporan_keuangan.php" role="tab" aria-controls="settings">
                <i class="fa fa-calculator" aria-hidden="true"></i>
                Laporan Keuangan
            </a>
            <a class="list-group-item list-group-item-action list-group-item-dark" id="list-settings-list"
                href="../logout.php" role="tab" aria-controls="settings">
                <i class="fa fa-power-off" aria-hidden="true"></i>
                Keluar
            </a>
            <a class="list-group-item list-group-item-dark" id="list-settings-list" role="tab" aria-controls="settings"
                style="height:324px;"></a>
        </div>
    </div>
    <div class="col-9 border bg-light" style="height:568px;">
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-content" id="v-pills-tabContent">
                <br>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                            Kelola Data Pegawai
                        </li>
                    </ol>

                    <div class="row">
                        <div class="col">
                            <form action="" method="get">
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
                                        <a href="../cetak/laporan_data_petugas.php" target="_blank" style="width:148px;" type="button" class="btn btn-success btn-sm">Cetak</a>
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
                                $halaman = 8;
                                $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
                                $mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
                                $query = mysqli_query($link, "SELECT * FROM t_pegawai");
                                $total = mysqli_num_rows($query);
                                
                                if(isset($_GET['cari'])){
                                    $data = $_GET['cari'];
                                    $queryCari = mysqli_query($link,"SELECT * FROM t_pegawai WHERE nama like '%".$data."%' OR jabatan like '%".$data."%'")or die(mysql_error);
                                    $totDataCari = mysqli_num_rows($queryCari);
                                    $pages = ceil($totDataCari/$halaman);
                                    $jalankan = mysqli_query($link,"SELECT * FROM t_pegawai WHERE nama like '%".$data."%' OR jabatan like '%".$data."%' ORDER BY nama ASC LIMIT $mulai, $halaman")or die(mysql_error);
                                }else{
                                    $jalankan = mysqli_query($link,"SELECT * FROM t_pegawai ORDER BY nama ASC LIMIT $mulai, $halaman")or die(mysql_error);
                                    $pages = ceil($total/$halaman);
                                }

                                while($data = mysqli_fetch_assoc($jalankan)){
                                    if($data['jk']=='L'){
                                        $jk = 'Laki-Laki';
                                    }else{
                                        $jk = 'Perempuan';
                                    }
                        ?>
                        <tbody>
                            <tr>
                                <td>
                                    <center><?= $data['nip'] ?></center>
                                </td>
                                <td>
                                    <?= ucwords($data['nama']) ?>
                                </td>
                                <td>
                                    <center><?= $jk ?></center>
                                </td>
                                <td>
                                    <center><?= ucwords($data['jabatan']) ?></center>
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

<!-- Modal Input Data -->
<div class="modal fade" id="input_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Data Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="nama" class="col-form-label">Nama :</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" id="nama" name="nama" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="jk" class="col-form-label">Jenis Kelamin :</label>
                            </div>
                            <div class="col">
                                <?php
                                $jk = "<font name='jk' id='jk'></font>";
                                ?>
                                <select name="l" id="l" class="form-control" style="width:175px;">
                                    <option value="">
                                        <-- Pilih Disini -->
                                    </option>
                                    <option value="L">L</option>
                                    <option value="P">P</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="tgl_lahir" class="col-form-label">Tanggal Lahir :</label>
                            </div>
                            <div class="col">
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="jabatan" class="col-form-label">Jabatan :</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" id="jabatan" name="jabatan" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" name="tambah">Lanjutkan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
            <div class="modal-footer">
                <i class="fa fa-copyright" aria-hidden="true"> 2019 Vixma Group</i>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Modal Input Data -->

<!-- Modal Edit Data -->
<div class="modal fade" id="edit_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="nip" class="col-form-label">NIP :</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" id="nip" name="nip" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="nama" class="col-form-label">Nama :</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" id="nama" name="nama" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="jk" class="col-form-label">Jenis Kelamin :</label>
                            </div>
                            <div class="col">
                                <?php
                                $jk = "<font name='jk' id='jk'></font>";
                                ?>
                                <select name="l" id="l" class="form-control" style="width:80px;">
                                    <option value=<?=$jk?>></option>
                                    <option value="L">L</option>
                                    <option value="P">P</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="jabatan" class="col-form-label">Jabatan :</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" id="jabatan" name="jabatan" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" name="ubah">Lanjutkan</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="nip" id="nip" hidden><br>
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
        var recipient = button.data('whatever')
        var nip = button.data('nip')
        var nama = button.data('nama')
        var jk = button.data('jk')
        var jabatan = button.data('jabatan')
        var modal = $(this)
        modal.find('.modal-body input').val(recipient)
        modal.find('.modal-body #nip').val(nip)
        modal.find('.modal-body #nama').val(nama)
        modal.find('.modal-body #jk').val(jk)
        modal.find('.modal-body #jabatan').val(jabatan)
        modal.find('.modal-body #jk').text(jk)
    })

    $('#hapus_data').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('whatever')
        var nip = button.data('nip')
        var nama = button.data('nama')
        var jk = button.data('jk')
        var jabatan = button.data('jabatan')
        var modal = $(this)
        modal.find('.modal-body input').val(recipient)
        modal.find('.modal-body #nip').val(nip)
        modal.find('.modal-body #nama').val(nama)
        modal.find('.modal-body #jk').val(jk)
        modal.find('.modal-body #jabatan').val(jabatan)
        modal.find('.modal-body #nama').text(nama)
    })
</script>
<!-- Akhir JavaScript -->

<?php
bawah();
?>