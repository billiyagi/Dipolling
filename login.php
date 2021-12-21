<?php

// Cek Session
session_start();
ob_start();
require 'core/server.php';

$fetching = new ShowFetch(DB::$conn);
$recoveryPassword = new Recovery(DB::$conn);

if (isset($_SESSION['login'])) {
    header("Location: admin/dashboard");
}

if (isset($_REQUEST['submit'])) {
     $resultLogin = new LoginSystem(DB::$conn, $_REQUEST);
    if ($resultLogin->LoginUser() === true) {

          //set Session
          $_SESSION['login'] = true;
          $_SESSION['username'] = htmlspecialchars($_REQUEST['username']);
          if (is_null($_COOKIE['chart'])) {
               setcookie('chart', 'bar', time()+60*60*24*30);
          }
          //Redirect
          header("Location: admin/dashboard");

     }elseif($resultLogin->LoginUser() === 'username'){
        echo ShowNotify(false, "Account not found");

     }elseif($resultLogin->LoginUser() === 'password'){
        echo ShowNotify(false, "Wrong password");
     }

}

if ( isset( $_REQUEST['submit_recovery'] ) ) {
     if ($recoveryPassword->SetRecoveryPassword($_REQUEST)) {
          header("Location: login?recovery=success");
     }
}

if ( isset( $_REQUEST['submit_forgot'] ) ) {

     // Filter Email
     $email = htmlspecialchars(
               strip_tags(
                    filter_var($_REQUEST['email_forgot'], FILTER_VALIDATE_EMAIL)
          )
     );

     if ( $email ) {
          if ( !is_null( $result = $fetching->GetSingleFetch("SELECT * FROM dipolling_users WHERE email='$email'") ) ) {
               $newRecoveryKey = uniqid();
               $recoveryPassword->SetMakeRecovery($result['email'], $newRecoveryKey);
               $mail = new Mail();
               $mail->SetSendMailRecovery($result['email'], $newRecoveryKey);
               header("Location: login?forgot=success");
          }else{
               header("Location: login?forgot=failed");
          }
     }else{
          header("Location: login?forgot=failed");
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
    <link rel="stylesheet" href="assets/fonts/Bootstrap-Icon/bootstrap-icons.css">

</head>
<body class="bg-light">

<!-- Back button -->
<div class="dip-back-page pt-3 ps-3 mb-3">
    <a href="index.php" class="text-decoration-none text-secondary fs-6">
        <i class="bi bi-arrow-left"></i> Home
    </a>
</div>

<div class="d-flex justify-content-center">
    <div class="dip-login-container">
          <?php if(isset($_GET['forgot'])): ?>

               <!-- Send key Recovery Account Page -->

                    <form action="<?= PageSelf(); ?>?forgot" method="post">
                        <!-- This is Copyright Under MIT License (c)
                            DO NOT REMOVE IT -->
                        <span class="dip-brand text-decoration-none text-secondary text-center d-block">Dipolling</span>
                        <!-- This is Copyright Under MIT License (c)
                            DO NOT REMOVE IT -->

                         <?php if ( isset($_GET['forgot']) && $_GET['forgot'] == 'success' ) : ?>
                              <div class="alert alert-success alert-dismissible fade show" role="alert">
                                   <strong>Email Sent!</strong> Check your mailbox also check your spam folder.
                                   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>
                         <?php elseif ( isset($_GET['forgot']) && $_GET['forgot'] == 'failed' ) : ?>
                              <div class="alert alert-success alert-dismissible fade show" role="alert">
                                   <strong>Failed</strong> The email you entered is not registered
                                   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>
                         <?php endif; ?>

                        <div class="input-group mb-3 mt-4">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" name="email_forgot" class="form-control" placeholder="Email on your account" autofocus required>
                        </div>
                        <button type="submit" name="submit_forgot" class="btn btn-primary w-100 fw-bold">Recovery</button>
                        <p class="text-center mt-3">Back to <a href="login">login</a></p>
                    </form>

          <?php elseif(isset($_GET['recovery'])): ?>

               <?php
                    // Get key from DB
                    $recoveryKey = htmlspecialchars(strip_tags($_GET['recovery']));
                    $mailResult = $fetching->GetSingleFetch("SELECT * FROM dipolling_mail_recovery WHERE recovery_key='$recoveryKey'");
               ?>

               <!-- Recovery Account Page -->
               <?php if ($_GET['recovery'] && !is_null($mailResult)): ?>

                    <form action="<?= PageSelf(); ?>?recovery=<?= $_GET['recovery'] ?>" method="post">
                        <!-- This is Copyright Under MIT License (c)
                            DO NOT REMOVE IT -->
                        <span class="dip-brand text-decoration-none text-secondary text-center d-block">Dipolling</span>
                        <!-- This is Copyright Under MIT License (c)
                            DO NOT REMOVE IT -->

                        <div class="input-group mb-3 mt-4">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-key-fill"></i></span>
                            <input type="password" name="password_recovery" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2" required>
                        </div>
                        <input type="hidden" name="mail" value="<?= $mailResult['email']; ?>">
                        <button type="submit" name="submit_recovery" class="btn btn-primary w-100 fw-bold">Change Password</button>
                    </form>

               <?php elseif($_GET['recovery'] == "success"): ?>
                    <div class="card p-3 text-center mt-5">
                         <i class="bi bi-check-circle text-success mb-2" style="font-size: 3.5rem;"></i>
                         <h5>Password change successful</h5>
                         <a href="login" class="btn btn-primary mt-3">Login</a>
                    </div>
               <?php else: ?>
                    <div class="card p-3 text-center mt-5">
                         <h5>There's no matching recovery key</h5>
                         <p class="mt-3 m-0">back to <a href="login">Login</a></p>
                    </div>
               <?php endif; ?>
          <?php else: ?>

               <!-- Login Page -->

               <form action="<?= PageSelf(); ?>" method="post">

                   <!-- This is Copyright Under MIT License (c)
                       DO NOT REMOVE IT -->
                   <span class="dip-brand text-decoration-none text-secondary text-center d-block">Dipolling</span>
                   <!-- This is Copyright Under MIT License (c)
                       DO NOT REMOVE IT -->

                    <?php if (isset($_REQUEST['username'])): ?>
                         <div class="input-group mb-3 mt-4">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-fill"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $_REQUEST['username'];?>" required>
                         </div>
                         <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2"><i class="bi bi-key-fill"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2" required>
                         </div>
                    <?php else: ?>
                         <div class="input-group mb-3 mt-4">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-fill"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Username" aria-label="Username" autofocus aria-describedby="basic-addon1" required>
                         </div>
                         <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2"><i class="bi bi-key-fill"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" autofocus aria-describedby="basic-addon2" required>
                         </div>
                    <?php endif; ?>

                   <button type="submit" name="submit" class="btn btn-primary w-100 fw-bold">Login</button>
               </form>
               <a href="login?forgot" class="text-center d-block mt-3">Forgot Password</a>
          <?php endif; ?>
    </div>
</div>

<!-- Internal Javascript -->
<script src="<?= HomeUrl() . '/assets/js/dipolling.js'; ?>"></script>

<!-- JS Bootstrap -->
<script src="<?= HomeUrl() . '/assets/js/bootstrap.bundle.min.js'; ?>"></script>
<script src="<?= HomeUrl() . '/assets/js/bootstrap.min.js'; ?>"></script>

<!-- JS Jquery -->
<script src="<?= HomeUrl() . '/assets/js/jquery-3.4.1.slim.min.js'; ?>"></script>

</body>
</html>
<?php ob_flush(); ?>
