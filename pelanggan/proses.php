<?php
session_start();
$no_meja = $_SESSION['username'];
require '../layout_function.php';

if(isset($_POST['orderAdmin'])){
    $no_meja = $_POST['meja'];
    $nama = $_POST['nama'];
    $ambil_data = mysqli_query($link, "SELECT * From sementara");
    while($data = mysqli_fetch_assoc($ambil_data)){
        $kode = $data['kode'];
        $jumlah = $data['jumlah'];
        $total = $data['total'];

        $query = "INSERT INTO pesan VALUES ('','$no_meja','$nama','$kode','$jumlah','$total')";
        $order = mysqli_query($link, $query);
    }

    if( mysqli_affected_rows($link) > 0 ) {
        mysqli_query($link, "DELETE from sementara");
        header('location:order_menu_admin.php');
    }else{
        echo mysqli_error($link);
    }
}elseif(isset($_GET['id'])){
    $kode = $_GET['id'];
    $ambil_data = mysqli_query($link, "SELECT * FROM sementara WHERE no_meja='$no_meja' && kode='$kode'");
    while($data = mysqli_fetch_array($ambil_data)){
        $jumlah = $data['jumlah'];
        $harga = $data['harga'];
        $kurang = $jumlah-1;
        $total = $kurang*$harga;

        if($jumlah > 1){
            $query = mysqli_query($link, "UPDATE sementara SET jumlah='$kurang', total='$total' WHERE no_meja='$no_meja' && kode='$kode'");
        }else if($jumlah == 1){
            $query = mysqli_query($link, "DELETE from sementara WHERE kode='$kode'");
        }
    }

    if( mysqli_affected_rows($link) > 0 ) {
        if($no_meja > 0){
            header('location:order_menu.php');
        }else{
            header('location:order_menu_admin.php');
        }
    }else{
        echo mysqli_error($link);
    }
}else{
    if($_GET['no'] > 0){
        $no_meja = $_GET['no'];
        $aksi = mysqli_query($link, "DELETE from sementara WHERE no_meja='$no_meja'");

        if( mysqli_affected_rows($link) > 0 ) {
            header('location:order_menu.php');
        }else{
            echo mysqli_error($link);
        }
        header('location:order_menu.php');
    }else{
        $no_meja = $_GET['no'];
        $aksi = mysqli_query($link, "DELETE from sementara WHERE no_meja='$no_meja'");

        if( mysqli_affected_rows($link) > 0 ) {
            header('location:order_menu_admin.php');
        }else{
            echo mysqli_error($link);
        }

        header('location:order_menu_admin.php');
    }
}
?>