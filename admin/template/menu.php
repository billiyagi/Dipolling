<?php
require '../core/server.php';
// Cek Session
session_start();
ob_start();

// Jika session tidak ada redirect ke login
if ( !isset($_SESSION['login'] ) ) {
    header( "Location: ../login" );
}

// Buat halaman saat ini (untuk nav)
$self_page = explode( 'admin', $_SERVER['PHP_SELF'] )[1];

// Init Settings
$showPolling = new ShowFetch( DB::$conn );
$setting = $showPolling->GetSingleFetch( "SELECT * FROM dipolling_settings" );

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="../assets/img/<?= $setting['site_icon']; ?>">
    <script type="text/javascript" src="../assets/js/chart.js"></script>
    <title>
        <?php switch ( $self_page ) {
          case '/dashboard.php':
               echo 'Dashboard';
               break;

          case '/polling.php':
               echo 'Polling';
               break;

          case '/account.php':
               echo 'Account';
               break;

          case '/settings.php':
               echo 'Settings';
               break;

          case '/poll.php':
               echo 'Set Poll';
               break;

          case '/poll-item.php':
               echo 'Set Item Poll';
               break;

          case '/poll-delete.php':
               echo 'Delete Poll Table';
               break;

          case '/poll-active.php':
               echo 'Set Active Poll';
               break;

          case '/report.php':
               echo 'Report Bug';
               break;

          case '/poll-reset.php':
               echo 'Reset Polling';
               break;

          case '/surveys.php':
               echo 'Survey';
               break;

          case '/survey.php':
               if ( $_GET['page'] == "add" ) {
                    echo 'Survey add';
               }elseif ( $_GET['page'] == "edit" ) {
                    echo 'Survey Edit';
               }elseif ( $_GET['page'] == "survey_answer" ) {
                    echo 'Survey Answer';
               }
               break;

          default:
               header("Location: dashboard");
               break;

        }

        ?> - Dipolling
    </title>

    <!-- Internal CSS -->
    <link rel="stylesheet" href="../assets/css/admin-dipolling.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

    <!-- Bootstrap Icon CSS -->
    <link rel="stylesheet" href="../assets/fonts/Bootstrap-Icon/bootstrap-icons.css">

</head>
<body class="bg-light text-dark" id="theBody">

<!-- Loading -->
<div id="dip-loader" class="d-none">
     <div class="box-dip-loader text-center">
          <div class="spinner-border mb-2 text-primary" role="status"></div>
          <br>
          <span class="text-secondary">Please Wait..</span>
     </div>
</div>

<!-- Menu -->
<header class="bg-light" id="menuAdmin">

    <!-- This is Copyright Under MIT License (c)
    DO NOT REMOVE IT -->
    <div class="text-secondary position-relative">
    <div class="dip-brand">
        Dipolling
    </div>
    <small class="d-block text-secondary dip-version">version 2.0.1</small>
    </div>
    <!-- This is Copyright Under MIT License (c)
    DO NOT REMOVE IT -->


    <nav>
        <ul>
            <li>
                <a href="dashboard" class="text-dark">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="polling" class="text-dark">
                    <i class="bi bi-journals"></i> Polling
               </a>
            </li>
            <li>
               <a href="surveys" class="text-dark">
                    <i class="bi bi-bar-chart-line"></i> Survey
               </a>
            </li>
            <li>
                <a href="account" class="text-dark">
                    <i class="bi bi-person-circle"></i> Account
               </a>
            </li>
            <li>
                <a href="settings" class="text-dark">
                    <i class="bi bi-gear"></i> Settings
               </a>
            </li>
            <li>
                <a href="report" class="text-dark">
                    <i class="bi bi-bug"></i> Report
                </a>
            </li>
        </ul>
    </nav>

    <div class="dip-logout" id="displayModeBtn">
        <!-- Button trigger modal -->
        <button type="button" class="bg-dark text-light" data-bs-toggle="modal" data-bs-target="#Logout">
            <span class="bi bi-power fs-5"></span>
        </button>
    </div>

    <button type="button" id="menuAdminBtn">
        <i class="bi bi-chevron-right" id="logoAdminBtn"></i>
    </button>
</header>


<main>

<!-- Modal logout -->
<div class="modal fade" id="Logout" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-body">
            <p class="text-center mt-5 mb-5 fw-bold fs-3">You want to leave? <i class="bi bi-emoji-frown text-success"></i></p>
            <div class="text-center">
                <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="logout" class="btn btn-lg btn-primary">Exit</a>
            </div>
        </div>
        </div>
    </div>
</div>
