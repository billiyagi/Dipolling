<?php require '../core/server.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dipolling</title>

    <!-- Internal CSS -->
    <link rel="stylesheet" href="../assets/css/admin-dipolling.css">

    <!-- Icons Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body class="bg-light text-dark" id="theBody">

<!-- Menu -->
<header class="bg-light" id="menuAdmin">
    <div class="dip-brand text-secondary">
        Dipolling
    </div>
    <nav>
        <ul>
            <li>
                <a href="index.php" class="text-dark">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="polling.php" class="text-dark">
                    <i class="bi bi-bar-chart-line"></i> Polling</a>
            </li>
            <li>
                <a href="account.php" class="text-dark">
                    <i class="bi bi-person-circle"></i> Account</a>
            </li>
            <li>
                <a href="settings.php" class="text-dark">
                    <i class="bi bi-gear"></i> Settings</a>
            </li>
        </ul>
    </nav>
    <div class="dip-mode" id="displayModeBtn">
        <button type="button" class="bg-dark text-light">
            <i class="bi bi-power fs-5"></i>
        </button>
    </div>
    <button type="button" id="menuAdminBtn">
        <i class="bi bi-chevron-right" id="logoAdminBtn"></i>
    </button>
</header>
<main>
