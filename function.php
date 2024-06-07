<?php 
include './config/dbconnect.php';


    //sign in
    if(isset($_POST['signinbar'])){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $enpassword = hash('sha256', $password);

            $insert = mysqli_query($conn,"INSERT INTO user (username,password) values ('$username','$enpassword') ") or die(mysqli_error($conn));

            if($insert){
                header('location:index.php');
            } else{
                echo '
                <script>
                    alert("GAGAL");
                    window.location.href="signin.php";
                </script>
                ';

            }

        }
    //login
    if(isset($_POST['loginbar'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $data = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
        $cek = mysqli_num_rows($data);
        $pass = mysqli_fetch_array($data);
        $passdb = $pass['password'];

        $enpassword = hash('sha256', $password);
        

        if($cek>0){
            
            if($passdb == $enpassword){
                header('location:mainMenu.php');
            } else{
                echo '
            <script>
                alert("Username atau Password SALAH!!!");
                window.location.href="index.php";
            </script>
            ';
            }
        } else{
            echo '
            <script>
                alert("Belum Terdaftar, Silahkan Registrasi Terlebih Dahulu");
                window.location.href="index.php";
            </script>
            ';

        }

    }
?>