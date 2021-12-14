<?php
require_once 'config.php';
require_once 'class/DB.php';
require_once 'function.php';
error_reporting(0);

// Init database Connection
$DB = new DB( $db_host_name, $db_username, $db_password, $db_name );

// cek instalasi


if ( $DB->connect_errno() != 0 || empty( $db_host_name ) || empty( $db_username ) || empty( $db_name )  ){
     session_start();
     $_SESSION['install'] = true;
     header("Location: install");
}
