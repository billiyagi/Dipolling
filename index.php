<?php
require 'core/server.php';
if (isset($db_error)) {
    header("Location: instalation");
}
// ambil nama tabel yang kolom polling_active nya = 1
$result = $show_polling->get_Query('SELECT * FROM list_table WHERE polling_active=1');
$name_active_polling = $show_polling->singleFetch($result);

// cek polling yang sedang aktif atau tidak ada polling yang aktif
if (!empty($name_active_polling)) {
    $name_active_polling_s = $name_active_polling['name'];

    //Jika $name_active_polling_s tidak NULL(kosong) result akan mengembalikan value dari fungsi loopFetch
    if (!empty($name_active_polling_s)) {
        // Show Polling
        $result_show_active_polling = $show_polling->get_Query("SELECT * FROM $name_active_polling_s");
        $rows_active = $show_polling->loopFetch($result_show_active_polling);
    }
}
// ambil polling yang dipilih
if (isset($_POST['submit'])) {
    $get_poll_id = $_POST['poll'];
    // Menambahkan +1 ke dalam data row tabel yang dipilih
    $dipolling->VotePoll($name_active_polling_s, $get_poll_id);

    $vote_success = true;
}


// Init Settings
$query_settings = $show_polling->get_Query("SELECT * FROM dipolling_settings");
$setting = $show_polling->singleFetch($query_settings);

$self_page = explode('/', $_SERVER['PHP_SELF']);
$result_self_page = end($self_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Internal CSS -->
    <link rel="stylesheet" href="assets/css/dipolling.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title><?= $setting['site_name']; ?></title>
    <link rel="icon" href="assets/img/<?= $setting['site_icon']; ?>" type="image/x-icon">
</head>
<body class="bg-light">

<div class="d-flex justify-content-center">
    <div class="dip-wd">
        <?php if ($setting['site_hide_login'] > 0): ?>
            <header class="d-flex justify-content-center align-items-center pt-5 pb-5">
        <?php else: ?>
            <header class="d-flex justify-content-between align-items-center pt-5 pb-5">
        <?php endif ?>
            <a href="<?= $result_self_page; ?>" class="dip-brand text-decoration-none fs-2 text-secondary">
                <img src="assets/img/<?= $setting['site_icon']; ?>" alt="<?= $setting['site_name']; ?>" width="100px">
            </a>
            <?php if ($setting['site_hide_login'] > 0): ?>
            <?php else: ?>
                <a href="login" class="btn btn-lg btn-outline-dark">Login</a>
            <?php endif ?>
        </header>
        <main>
        <?php if ($setting['site_maintenance'] > 0): ?>
            <!-- Maintenance -->
            <div class="d-flex justify-content-center">
                <div class="dip-maintenance">
                    <img src="assets/img/mg/undraw_not_found_-60-pq.svg">
                    <p class="text-center mt-3 fs-2">We're not ready yet!</p>
                </div>
            </div>
        <?php else: ?>
            <!-- Container polling -->
            <div class="dip-container-pol dip-mt-8">
                <div class="dip-title-pol text-center">
                <?php if(!isset($vote_success)): ?>
                    <?php if (isset($name_active_polling_s)): ?>
                        <h3 class="text-capitalize fw-bold">
                            <?php echo str_replace('_', ' ', $name_active_polling_s); ?>
                        </h3>
                    <?php endif; ?>
                <?php endif; ?>
                </div>

                <!-- form polling -->
                <form action="" method="post">
                    <div class="mt-5 mb-5 row d-flex justify-content-center">
                    <?php if(!isset($name_active_polling_s)): ?>
                        <img src="assets/img/mg/undraw_well_done_i2wr.svg" class="dip-welcome-polling">
                        <h2 class="text-center mt-5">Welcome to Dipolling!</h2>
                        <p class="text-center text-secondary">This main page to show your polling!</p>
                    <?php elseif(isset($vote_success)): ?>
                        <div class="text-center">
                            <img src="assets/img/mg/Balloons.gif" alt="">
                            <h2>Thank you for participating</h2>
                        </div>
                    <?php else: ?>
                        <?php $i = 1; ?>
                        <?php foreach($rows_active as $row): ?>
                            <div class="col-lg-4 mt-4">

                                <!-- card polling -->
                                <div class="dip-card card" id="ad">
                                    <img src="assets/img/pollimg/<?= $row['polimg']; ?>" alt="<?= $row['polname']; ?>" class="dip-cover-img">
                                    <div class="card-title text-center pt-2 ps-1 pe-1 fs-5">
                                        <?= $row['polname']; ?>
                                    </div>
                                    <input class="dip-check" type="radio" name="poll" value="<?= $row['id']; ?>" id="rad_<?= $row['id']; ?>">
                                    <label for="rad_<?= $row['id']; ?>" onclick="btnSubmit()"></label>
                                    <img src="assets/img/<?= $setting['site_poll_icon']; ?>" alt="Check" class="dip-check-img dip-none">
                                </div>
                            </div>
                        <?php $i++ ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                    <div id="submitVote">
                        <button type="submit" name="submit" class="btn btn-lg btn-primary d-block w-100 pt-3 pb-3 fs-4">Confirm</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
        </main>
        <footer>
            <div class="powered-dipolling">
                <!-- Do Not remove this Copyright -->
                <small class="opacity-50 dip-no-mar">Powered by</small>
                <h1 class="text-secondary dip-brand opacity-50">Dipolling</h1>
            </div>
        </footer>
    </div>
</div>




<!-- Internal Javascript -->
<script src="assets/js/dipolling.js"></script>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery-3.4.1.slim.min.js"></script>

<!-- Bootstrap Javascript Separate -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script> -->

<!-- Bootstrap Javascript Bundle -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
</body>
</html>
