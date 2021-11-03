<?php 
include "template/menu.php";

$username = $_SESSION['username'];

// Tampilkan Account 
$show_account_sql = "SELECT * FROM dipolling_users WHERE username='$username'";
$result_account_sql = $show_polling->get_Query($show_account_sql);
$account = $show_polling->singleFetch($result_account_sql);
?>
    <div class="dib-admin-page-title fs-4 text-dark fw-bold">
        <i class="bi bi-person-circle"></i> Account
    </div>
    <form class="" action="index.html" method="get">
        <div class="mb-3 row">
            <label for="username" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
                <input type="text" name="username" readonly class="form-control-plaintext" id="username" value="<?= $account['username']; ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" value="<?= $account['name']; ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?= $account['email']; ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary btn-lg mt-5"><i class="bi bi-check2-square"></i> Save Changes</button>
    </form>
<?php include "template/main.php"; ?>
