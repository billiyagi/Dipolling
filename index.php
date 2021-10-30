<?php
require 'core/server.php';

// ambil nama tabel yang kolom polling_active nya = 1

$result = $show_polling->get_Query('SELECT * FROM list_table WHERE polling_active=1');
$name_active_polling = $show_polling->singleFetch($result);
$name_active_polling_s = $name_active_polling['name'];
// Show Polling
$result_show_active_polling = $show_polling->get_Query("SELECT * FROM " . $name_active_polling);
$rows_active = $show_polling->loopFetch($result_show_active_polling);
?>
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

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body class="bg-light">

<div class="d-flex justify-content-center">
    <div class="dip-wd">
        <header class="d-flex justify-content-between align-items-center pt-3 pb-3">
            <a href="#" class="dip-brand text-decoration-none fs-2 text-secondary">Dipolling</a>
            <a href="login.php" class="btn btn-secondary">Login</a>
        </header>
        <main>
            <!-- Container polling -->
            <div class="dip-container-pol dip-mt-8">
                <div class="dip-title-pol text-center">
                    <h3>Pemilihan Ketua Osis</h3>
                </div>
                <!-- form polling -->
                <form action="" method="get">
                    <div class="mt-5 mb-5 row d-flex">
                        <?php foreach($rows_active as $row): ?>
                            <div class="col-sm-4 mt-4">
                                <!-- card polling -->
                                <div class="dip-card card" id="ad">
                                    <img src="assets/img/women.jpg" alt="">
                                    <div class="card-title text-center pt-2">
                                        <?= $row['name']; ?>
                                    </div>
                                    <input class="dip-check" type="radio" name="pemilihan" value="person<?= $row['id']; ?>" id="rad_<?= $row['id']; ?>">
                                    <label for="rad_<?= $row['id']; ?>" onclick="btnSubmit()"></label>
                                    <img src="assets/img/<?= $row['polling']; ?>" alt="Check" class="dip-check-img dip-none">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div id="submitVote" class="p-2">
                        <button type="submit" name="submit" class="btn btn-lg btn-primary d-block w-100">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </main>
        <footer>
            <div class="powered-dipolling">
                <small class="opacity-50 dip-no-mar">Powered by</small>
                <h1 class="text-secondary dip-brand opacity-50">Dipolling</h1>

            </div>
        </footer>
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
