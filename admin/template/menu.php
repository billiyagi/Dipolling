<?php 
require '../core/server.php'; 
// Cek Session
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login");
}
$self_page = explode('admin', $_SERVER['PHP_SELF'])[1];

// Init Settings
$query_settings = $show_polling->get_Query("SELECT * FROM dipolling_settings");
$setting = $show_polling->singleFetch($query_settings);
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
        <?php switch ($self_page) {
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
            default:
                header("Location: dashboard");
                break;
        } ?> - Dipolling
    </title>

    <!-- Internal CSS -->
    <link rel="stylesheet" href="../assets/css/admin-dipolling.css">

    <!-- Icons Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body class="bg-light text-dark" id="theBody">

<!-- Menu -->
<header class="bg-light" id="menuAdmin">
    
    <!-- This is Copyright Under MIT License (c) 
    DO NOT REMOVE IT -->
    <div class="dip-brand text-secondary">
        Dipolling
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
                    <i class="bi bi-bar-chart-line"></i> Polling</a>
            </li>
            <li>
                <a href="account" class="text-dark">
                    <i class="bi bi-person-circle"></i> Account</a>
            </li>
            <li>
                <a href="settings" class="text-dark">
                    <i class="bi bi-gear"></i> Settings</a>
            </li>
        </ul>
    </nav>
    <div class="dip-mode" id="displayModeBtn">
        <!-- Button trigger modal -->
        <button type="button" class="bg-dark text-light" data-bs-toggle="modal" data-bs-target="#Logout">
            <i class="bi bi-power fs-5"></i>
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
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Logout</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p class="text-center mt-5 mb-5 fw-bold">Apakah Kamu yakin ingin keluar?</p>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="logout.php" class="btn btn-primary"><i class="bi bi-power"></i> Logout</a>
            </div>
        </div>
    </div>
</div>  
