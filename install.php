<?php

require_once 'core/function.php';
session_start();

// Check installation Session
if (!isset($_SESSION['install'])) {
     header("Location: index.php");
}

// Instalation process
if (isset($_REQUEST['submit'])) {

     // Database
     $db_host = htmlspecialchars($_REQUEST['database_host']);
     $db_name = htmlspecialchars($_REQUEST['database_name']);
     $db_username = htmlspecialchars($_REQUEST['database_username']);
     $db_password = htmlspecialchars($_REQUEST['database_password']);

     // Account
     $acc_name = htmlspecialchars($_REQUEST['account_name']);
     $acc_email = htmlspecialchars($_REQUEST['account_email']);
     $acc_username = htmlspecialchars($_REQUEST['account_username']);
     $acc_password = htmlspecialchars($_REQUEST['account_password']);

     // Site settings
     $settings_site_name = htmlspecialchars($_REQUEST['site_name']);


     // Create Configuration
     $myfile = fopen("core/config.php", "w");
     $txt = "<?php
     $" . "db_host_name = '$db_host';
     $" . "db_username = '$db_username';
     $" . "db_password = '$db_password';
     $" . "db_name = '$db_name';
     ?>";
     fwrite($myfile, $txt);
     fclose($myfile);

     require_once 'core/server.php';


     // Buat tabel: dipolling_list_table
     $query_list_table = 'CREATE TABLE dipolling_list_table (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(150), polling_active INT(5))';

     if (!mysqli_query(DB::$conn, $query_list_table)) {
          header("Location: install.php?failed=table_list");
     }


     // Buat tabel: dipolling_users
     $query_dipolling_users = 'CREATE TABLE dipolling_users (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(150), name VARCHAR(255), username VARCHAR(255), password VARCHAR(355))';

     if (!mysqli_query(DB::$conn, $query_dipolling_users)) {
          header("Location: install.php?failed=table_users");
     }


     // Buat tabel: dipolling_settings
     $query_dipolling_settings = 'CREATE TABLE dipolling_settings (settings_profile VARCHAR(255) PRIMARY KEY, site_name VARCHAR(255), site_icon VARCHAR(255), site_poll_icon VARCHAR(255), survey_template VARCHAR(255), site_hide_login INT(5), site_maintenance INT(5))';

     if (!mysqli_query(DB::$conn, $query_dipolling_settings)) {
          header("Location: install.php?failed=table_settings");
     }


     // Buat tabel: dipolling_survey
     $query_dipolling_survey = 'CREATE TABLE dipolling_survey (id INT AUTO_INCREMENT PRIMARY KEY, survey_key VARCHAR(255), survey_question VARCHAR(255), survey_img VARCHAR(255), survey_status INT(2))';

     if (!mysqli_query(DB::$conn, $query_dipolling_survey)) {
          header("Location: install.php?failed=table_survey");
     }


     // Buat tabel: dipolling_survey_answer
     $query_dipolling_survey_answer = 'CREATE TABLE dipolling_survey_answer (id INT AUTO_INCREMENT PRIMARY KEY, survey_id INT, survey_answer VARCHAR(3000), survey_date VARCHAR(255))';

     if (!mysqli_query(DB::$conn, $query_dipolling_survey_answer)) {
          header("Location: install.php?failed=table_survey_answer");
     }


     // Buat tabel: dipolling_mail_recovery
     $query_dipolling_mail_recovery = 'CREATE TABLE dipolling_mail_recovery (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255), recovery_key VARCHAR(255))';

     if (!mysqli_query(DB::$conn, $query_dipolling_mail_recovery)) {
          header("Location: install.php?failed=table_mail_recovery");
     }

     // Buat Folder untuk penyimpanan gambar
     mkdir('assets/img/pollimg');

     // Enkripsi
     $result_password = password_hash($acc_password, PASSWORD_BCRYPT);

     $query_account = "INSERT INTO dipolling_users VALUES( NULL, '$acc_email', '$acc_name' ,'$acc_username', '$result_password' )";

     if (!mysqli_query(DB::$conn, $query_account)) {
          header("Location: install.php?failed=account");
     }


     // Add images
     $dip_media = new MediaFiles($_FILES, 'assets/img/', ['jpg', 'png', 'jpeg'], 5000000, 'site_icon');

     $settings_site_icon = $dip_media->SetAddMedia('img');

     $min = -1;
     $query_settings = "INSERT INTO dipolling_settings VALUES( 'primary', '$settings_site_name', '$settings_site_icon', 'ok.png', 'top', $min, $min )";

     if (!mysqli_query(DB::$conn, $query_settings)) {
          header("Location: install.php?failed=settings");
     }

     // Destroy install session
     $_SESSION = [];

     session_unset();

     session_destroy();
     header("Location: index");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">

     <link rel="icon" href="<?= HomeUrl() . '/assets/img/mg/dipolling.ico' ?>" type="image/x-icon">

     <!-- Internal CSS -->
     <link rel="stylesheet" href="<?= HomeUrl() . '/assets/css/dipolling.css'; ?>">

     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="<?= HomeUrl() . '/assets/css/bootstrap.min.css'; ?>">

     <!-- Bootstrap Icon -->
     <link rel="stylesheet" href="<?= HomeUrl() . '/assets/fonts/Bootstrap-Icon/bootstrap-icons.css'; ?>">

     <title>Dipolling Instalation</title>
</head>

<body class="bg-light">

     <!-- Loading -->
     <div id="dip-loader" class="d-none">
          <div class="box-dip-loader text-center">
               <div class="spinner-border mb-2 text-primary" role="status"></div>
               <br>
               <span class="text-secondary">Please Wait..</span>
          </div>
     </div>

     <div class="container">
          <h1 class="dip-brand text-secondary text-center mt-5 mb-5" style="font-size: 3.5rem;">Dipolling</h1>
          <div class="card p-3 mb-5" style="background: #FFF;">

               <form action="<?= PageSelf(); ?>" method="post" enctype="multipart/form-data">

                    <!-- Database Instalation -->
                    <section class="database">
                         <h3 class="fw-bold mb-3">Database</h3>

                         <!-- Host Name -->
                         <label for="#hostName" class="control-label mb-2">Host Name <small class="text-secondary">default: localhost</small></label>
                         <input type="text" name="database_host" class="form-control mb-3" placeholder="Database Name" id="hostName" value="localhost" required>

                         <!-- Database name -->
                         <label for="#databaseName" class="control-label mb-2">Database Name</label>
                         <input type="text" name="database_name" class="form-control mb-3" placeholder="Database Name" id="databaseName" required>

                         <!-- Database Account -->
                         <label for="#databaseAccount" class="control-label">Database Account</label>
                         <div class="input-group" id="databaseAccount">
                              <input type="text" name="database_username" class="form-control mb-3" placeholder="Database Username" required>
                              <input type="password" name="database_password" class="form-control mb-3" placeholder="Database Password">
                         </div>
                    </section>

                    <hr>

                    <!-- Account Instalation -->
                    <section class="acccount">
                         <h3 class="fw-bold mb-3 mt-5">Account</h3>

                         <!-- Name Account -->
                         <label for="#name" class="control-label mb-2">Name</label>
                         <input type="text" name="account_name" class="form-control mb-3" placeholder="Name Account" id="name" required>

                         <!-- Email Account -->
                         <label for="#email" class="control-label mb-2">Email</label>
                         <input type="text" name="account_email" class="form-control mb-3" placeholder="Email address" id="email" required>

                         <!-- Username & Password Account -->
                         <label for="#basic_account" class="control-label mb-2">Username & Password</label>
                         <div class="input-group" id="basic_account">
                              <input type="text" name="account_username" class="form-control mb-3" placeholder=" Username" required>
                              <input type="password" name="account_password" class="form-control mb-3" placeholder="Password" required>
                         </div>
                    </section>

                    <hr>

                    <!-- Settings instalation -->

                    <section class="settings">
                         <h3 class="fw-bold mb-3 mt-5">Site Settings</h3>

                         <!-- Site Name -->
                         <label for="#siteName" class="control-label mb-2">Site Name</label>
                         <input type="text" name="site_name" class="form-control mb-3" placeholder="Site Name" id="siteName" required>

                         <!-- Site Icon -->
                         <label for="#siteIcon" class="control-label mb-2">Site Icon</label>
                         <input type="file" name="site_icon" class="form-control mb-3" placeholder="Site Icon" id="siteIcon" required>

                    </section>

                    <!-- Submit -->
                    <button type="submit" name="submit" class="btn btn-lg btn-primary mt-5">Instal Now</button>
               </form>
          </div>
     </div>
     <script src="assets/js/dipolling.js"></script>
</body>

</html>