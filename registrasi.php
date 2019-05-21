<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
require 'layout_function.php';

if(isset($_POST['registrasi'])){
    if(registrasi($_POST) > 0){
        echo "
            <script type='text/javascript'>
                setTimeout(function () {
                    swal({
                        title: 'Berhasil',
                        text: 'Selamat Bergabung',
                        icon: 'success',
                        timer: 3000,
                        button: false,
                    });
                }, 10);
                window.setTimeout(function () {
                    window.location.replace('halaman_login.php');
                }, 3000); 
            </script>
            ";
    }else{
        echo "
            <script type='text/javascript'>
                setTimeout(function () {
                    swal({
                        title: 'Gagal',
                        text: 'Data Gagal Ditambahkan',
                        icon: 'warning',
                        timer: 3000,
                        button: false,
                    });
                }, 10);
                window.setTimeout(function () {
                    window.location.replace('registrasi.php');
                }, 3000); 
            </script>
            ";
    }
}

atas();
?>
<style>
    .container {
        height:406px;
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
        <table class="table" style="width:60%; height:100%;">
            <tr class="row">
                <td class="col-12 border shadow" style="background:white;">
                    <center>
                        <form action="" method="post">
                            <table class="table" style="width:90%;">
                                <tr class="row text-center">
                                    <td class="col border">
                                        <a href="halaman_login.php" style="text-decoration:none"><font color="black">LOGIN</font></a>
                                    </td>
                                    <td class="col border border-bottom border-success" style="background:#C0C0C0;">
                                        <a href="registrasi.php" style="text-decoration:none"><font color="black"><b>REGISTRASI</b></font></a>
                                    </td>
                                </tr>
                                <tr class="row">
                                    <td class="col-3">
                                        <label for="nip">NIP :</label>
                                    </td>
                                    <td class="col">
                                        <input type="text" class="form-control form-control-sm" name="nip" id="nip"
                                            autocomplete="off">
                                    </td>
                                </tr>
                                <tr class="row">
                                    <td class="col-3">
                                        <label for="username">Username :</label>
                                    </td>
                                    <td class="col">
                                        <input type="text" class="form-control form-control-sm" name="username" id="username" autocomplete="off">
                                    </td>
                                </tr>
                                <tr class="row">
                                    <td class="col-3">
                                        <label for="password">Password :</label>
                                    </td>
                                    <td class="col">
                                        <input type="password" class="form-control form-control-sm" name="password" id="password">
                                    </td>
                                </tr>
                                <tr class="row">
                                    <td class="col-3">
                                        <label for="password2">Konfirmasi Password :</label>
                                    </td>
                                    <td class="col">
                                        <input type="password" class="form-control form-control-sm" name="password2" id="password2">
                                        <span>
                                            <a href="#" id="show" onclick="ShowPassword()">Lihat Password</a>
                                            <a href="#" style="display:none" id="hide" value="Hide Password"
                                                onclick="HidePassword()">Sembunyikan</a>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="row">
                                    <td class="col">
                                        <button type="submit" class="btn btn-success form-control" name="registrasi"
                                            id="registrasi">REGISTRASI</button>
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

            document.getElementById("password2").type = "text";
            document.getElementById("show").style.display = "none";
            document.getElementById("hide").style.display = "block";
        }
    }

    function HidePassword() {
        if (document.getElementById("password").type == "text") {
            document.getElementById("password").type = "password"
            document.getElementById("show").style.display = "block";
            document.getElementById("hide").style.display = "none";

            document.getElementById("password2").type = "password"
            document.getElementById("show").style.display = "block";
            document.getElementById("hide").style.display = "none";
        }
    }
</script>

<?php
bawah();
?>