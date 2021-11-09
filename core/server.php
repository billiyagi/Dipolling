<?php
require 'config.php';
require 'class.php';
error_reporting(0);

$dipolling = new Dipolling($db_host_name, $db_username, $db_password, $db_name);
$notify = new Notification($db_host_name, $db_username, $db_password, $db_name);
$show_polling = new dipollingTable($db_host_name, $db_username, $db_password, $db_name);

if($dipolling->connect_errno){
    $db_error = true; //result true / 1
}else{
    $db_error = false;
}

// cek instalasi
if ($db_error && empty($db_host_name) && empty($db_username) && empty($db_name) ){
    session_start();
    $_SESSION['instalation'] = 'database';
    header("Location: instalation?step=database");
}elseif( $db_error || empty($db_host_name) || empty($db_username) || empty($db_name) ){
    session_start();
    $_SESSION['instalation'] = 'error';
    header("Location: instalation?step=error");
}elseif(isset($_SESSION)){
    //jika ada session dan session itu instalasi hapus sessionnya
    if ($_SESSION['instalation']) {
        session_start();
        $_SESSION = [];
        session_unset();
        session_destroy();
    }
}