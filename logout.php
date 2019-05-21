<?php
 session_start(); // memulai session
 require'layout_function.php';
 session_destroy(); // menghapus session
 
 if($_GET['stat']){
    $no_meja = $_GET['stat'];
    $query = mysqli_query($link, "DELETE from sementara WHERE no_meja='$no_meja'");
    header('location:halaman_login.php');
 }

 header('location:halaman_login.php');

//  header("location:halaman_login.php"); // mengambalikan ke index.php
?>