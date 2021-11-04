<?php 
require 'core/server.php';

// Cek Session
session_start();
if (isset($_SESSION['login'])) {
    header("Location: admin/dashboard.php");
}

if (isset($_POST['submit'])) {
    $result_login = $dipolling->loginSystem($_POST, 'login');
    if ($result_login === true) {
        var_dump($result_login);
        
        //set Session
        $_SESSION['login'] = true;
        $_SESSION['username'] = htmlspecialchars($_POST['username']);

        // // Redirect
        header("Location: admin/dashboard.php");
    }elseif($result_login === 'username'){

        echo $notify->showNotify(false, "Akun tidak ditemukan");

    }elseif($result_login === 'password'){

        echo $notify->showNotify(false, "Password Salah");
    }

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="assets/img/mg/dipolling.ico">
    <title>Login - Dipolling</title>

    <!-- Internal CSS -->
    <link rel="stylesheet" href="assets/css/dipolling.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body class="bg-light">

<!-- Notification -->
<div class="dip-notification">
    username / password salah
</div>

<!-- Back button -->
<div class="dip-back-page pt-3 ps-3">
    <a href="index.php" class="text-decoration-none text-secondary fs-6">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>
<div class="d-flex justify-content-center">
    <div class="dip-login-container">
        <form action="" method="post">
            
            <!-- This is Copyright Under MIT License (c) 
                DO NOT REMOVE IT -->
            <a href="#" class="dip-brand text-decoration-none text-secondary text-center d-block">Dipolling</a>
            <!-- This is Copyright Under MIT License (c) 
                DO NOT REMOVE IT -->

            <div class="input-group mb-3 mt-4">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-fill"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" autofocus value="<?php 
                if(isset($_POST['username'])){
                 echo $_POST['username'];
             } ?>" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-key-fill"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100 fw-bold">Login</button>
        </form>
    </div>
</div>
</body>
</html>