<?php
$link = mysqli_connect('localhost','root','','new_resto');
$icon = "https://www.freeiconspng.com/uploads/restaurant-icon-png-10.png";
$label = "Resto Kang Kabayan";

Function atas(){
    echo '<!doctype html>
    <html lang="en">
      <head>

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        
        <title>Resto Kang Kabayan</title>
        <link rel="shortcut icon" href="https://www.freeiconspng.com/uploads/restaurant-icon-png-10.png">
      </head>
      <body>
      <style type="text/css">

      h1,h2,p,a{
        font-family: sans-serif;
        font-weight: normal;
      }
    
      .jam-digital-malasngoding {
        overflow: hidden;
        width: 330px;
      }
      .kotak{
        float: left;
        width: 106px;
        height: 100px;
        background-color: #189fff;
      }
      .jam-digital-malasngoding p {
        color: #fff;
        font-size: 36px;
        text-align: center;
        margin-top: 30px;
      }
        </style>';
}

Function JS(){
  echo '<!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  ';
}

Function bawah(){
    echo '</body> 
    </html>';
}

Function sementara($data){

  global $link;

  $meja = $data["meja"];
  $kode = $data["kode"];
  $qty = $data["qty"];

  $select = mysqli_query($link, "SELECT * FROM menu WHERE kode='$kode'");
  $data_menu = mysqli_fetch_assoc($select);

  $nama = $data_menu['nama'];
  $harga = $data_menu['harga'];
  $total = $qty * $harga;

  $query_cek = mysqli_query($link, "SELECT * FROM sementara WHERE no_meja='$meja' && kode='$kode'");
  $cek = mysqli_fetch_assoc($query_cek);
  $jumlah =  $cek['jumlah'];
  if(mysqli_num_rows($query_cek) > 0){
    $tambah1 =$jumlah + $qty;
    mysqli_query($link, "UPDATE sementara SET jumlah='$tambah1' WHERE no_meja='$meja' && kode='$kode'");
  }else{
    $query = "INSERT INTO sementara VALUES ('','$meja','$kode','$nama','$qty','$harga','$total')";
    mysqli_query($link, $query);
  }

  return mysqli_affected_rows($link);
}

Function total_bayar(){
  global $link;
  
}

Function reset_pesanan(){
  mysqli_query ($link, "TRUNCATE sementara");
}

Function registrasi($data){
  global $link;

  
  $nip = $data['nip'];
  $username = strtolower(stripcslashes($data['username']));
  $password1 = mysqli_real_escape_string($link, $data['password']);
  $password2 = mysqli_real_escape_string($link, $data['password2']);

  $cek_nip = mysqli_query($link, "SELECT * FROM t_pegawai WHERE nip='$nip'");
  if(mysqli_num_rows($cek_nip) == 0){
    echo "<script>
            alert('NIP yang anda masukan tidak terdaftar!')
          </script>";

    return false;
  }else if(mysqli_num_rows($cek_nip) == 1){
    while($data = mysqli_fetch_assoc($cek_nip)){
      $status = $data['jabatan'];
    }
  }

  $cek_nip_username = mysqli_query($link, "SELECT id, username FROM login WHERE id='$nip' OR username='$username'");
  if(mysqli_fetch_assoc($cek_nip_username)){
    echo "<script>
            alert('nip/username telah terdaftar!')
          </script>";

    return false;
  }

  if($password1 !== $password2){
    echo "<script>
            alert('Konfirmasi Password Tidak Sesuai')
          </script>";

    return false;
  }

  $password = password_hash($password1, PASSWORD_DEFAULT);

  $query = mysqli_query($link, "INSERT INTO login VALUES ('$nip','$username','$password','$status')");
  return mysqli_affected_rows($link);

}