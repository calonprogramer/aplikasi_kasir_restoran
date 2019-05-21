<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
// error_reporting(0);
session_start();
require 'layout_function.php';

if(isset($_POST['masuk'])){
    $username = $_POST['username'];
    $pass = $_POST['password'];

    $query = mysqli_query($link, "SELECT * FROM login WHERE username='$username'");
    $meja = mysqli_query($link, "SELECT * FROM login WHERE username='$username' && password='$pass'");
    $data = mysqli_fetch_assoc($query);
    $password = $data['password'];

    if(password_verify($pass, $password)){
        if($data['stat'] == "kasir"){
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $data['id'];
        $_SESSION['stat'] = $data['stat'];
        echo "
        <script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Berhasil',
                    text: 'Selamat Datang',
                    icon: 'success',
                    timer: 3000,
                    button: false,
                });
            }, 10);
            window.setTimeout(function () {
                window.location.replace('kasir/halaman_transaksi.php');
            }, 3000); 
        </script>
        ";
        }else if($data['stat'] == "admin"){
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $data['id'];
            $_SESSION['stat'] = $data['stat'];
            echo "
            <script type='text/javascript'>
                setTimeout(function () {
                    swal({
                        title: 'Berhasil',
                        text: 'Selamat Datang Admin',
                        icon: 'success',
                        timer: 3000,
                        button: false,
                    });
                }, 10);
                window.setTimeout(function () {
                    window.location.replace('admin/halaman_admin.php');
                }, 3000); 
            </script>
            ";
        }else if($data['stat'] == "waiter"){
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $data['id'];
            $_SESSION['stat'] = $data['stat'];
            $_SESSION['no_meja'] = $username;
            echo "
            <script type='text/javascript'>
                setTimeout(function () {
                    swal({
                        title: 'Berhasil',
                        text: 'Selamat Datang',
                        icon: 'success',
                        timer: 3000,
                        button: false,
                    });
                }, 10);
                window.setTimeout(function () {
                    window.location.replace('pelanggan/order_menu.php');
                }, 3000); 
            </script>
            ";
        }
    }else if($data['stat'] == "owner"){
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $data['id'];
        $_SESSION['stat'] = $data['stat'];
        echo "
        <script type='text/javascript'>
            setTimeout(function () {
                swal({
                    title: 'Berhasil',
                    text: 'Selamat Datang Bos',
                    icon: 'success',
                    timer: 3000,
                    button: false,
                });
            }, 10);
            window.setTimeout(function () {
                window.location.replace('owner/halaman_admin.php');
            }, 3000); 
        </script>
        ";
    }else if($meja){
        $_SESSION['no_meja'] = $username;
        header('location:pelanggan/order_menu.php');
    }else{
        echo "
            <script type='text/javascript'>
                setTimeout(function () {
                    swal({
                        title: 'Warning',
                        text: 'Username/Password Salah',
                        icon: 'warning',
                        timer: 3000,
                        button: false,
                    });
                }, 10);
                window.setTimeout(function () {
                    window.location.replace('halaman_login.php');
                }, 3000); 
            </script>
            ";
    }
}


atas();
?>
<style>
    .container {
        height: 200px;
        position: fixed;
        top: 50%;
        left: 50%;
        margin-top: -210px;
        margin-left: -563px;
    }

    body {
        background: #C0C0C0;
    }
</style>
<div class="container">
    <center>
        <table class="table" style="width:60%;">
            <tr class="row">
                <td class="col-12 border shadow" style="background:white;">
                    <center>
                        <form action="" method="post">
                            <table class="table" style="width:90%;">
                                <tr class="row text-center">
                                    <td class="col border border-bottom border-success" style="background:#C0C0C0;">
                                        <a href="halaman_login.php" style="text-decoration:none"><font color="black"><b>LOGIN</b></font></a>
                                    </td>
                                    <td class="col border">
                                        <a href="registrasi.php" style="text-decoration:none"><font color="black">REGISTRASI</font></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                </tr>
                                <tr class="row">
                                    <td class="col border">
                                        <center>
                                            <h1><b>SELAMAT DATANG!</b></h1>
                                        </center>
                                    </td>
                                </tr>
                                <tr class="row">
                                    <td class="col-3">
                                        <label for="username">Username :</label>
                                    </td>
                                    <td class="col">
                                        <input type="text" class="form-control" name="username" id="username"
                                            autocomplete="off">
                                    </td>
                                </tr>
                                <tr class="row">
                                    <td class="col-3">
                                        <label for="password">Password :</label>
                                    </td>
                                    <td class="col">
                                        <input type="password" class="form-control" name="password" id="password">
                                        <span>
                                            <a href="#" id="show" onclick="ShowPassword()">Lihat Password</a>
                                            <a href="#" style="display:none" id="hide" value="Hide Password"
                                                onclick="HidePassword()">Sembunyikan</a>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="row">
                                    <td class="col">
                                        <button type="submit" class="btn btn-success form-control" name="masuk"
                                            id="masuk">Masuk</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </center>
                </td>
            </tr>
        </table>
    </center>
</div>

<script>
    function ShowPassword() {
        if (document.getElementById("password").value != "") {
            document.getElementById("password").type = "text";
            document.getElementById("show").style.display = "none";
            document.getElementById("hide").style.display = "block";
        }
    }

    function HidePassword() {
        if (document.getElementById("password").type == "text") {
            document.getElementById("password").type = "password"
            document.getElementById("show").style.display = "block";
            document.getElementById("hide").style.display = "none";
        }
    }
</script>

<?php
bawah();
?>