<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dipolling</title>

    <!-- Internal CSS -->
    <link rel="stylesheet" href="assets/css/dipolling.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

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
        <form action="index.html" method="post">
            <a href="#" class="dip-brand text-decoration-none text-secondary text-center d-block">Dipolling</a>
            <div class="input-group mb-3 mt-4">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-fill"></i></span>
                <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-key-fill"></i></span>
                <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100 fw-bold">Masuk</button>
        </form>
    </div>
</div>




<!-- Internal Javascript -->
<script src="assets/js/dipolling.js"></script>

<!-- Bootstrap Javascript Separate -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

<!-- Bootstrap Javascript Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
