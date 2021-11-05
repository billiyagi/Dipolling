<?php
require 'config.php';
require 'class.php';
error_reporting(0);

$dipolling = new Dipolling($db_host_name, $db_username, $db_password, $db_name);
$notify = new Notification($db_host_name, $db_username, $db_password, $db_name);
$show_polling = new dipollingTable($db_host_name, $db_username, $db_password, $db_name);

if($dipolling->connect_errno){
    $db_error = true;
}else{
    $db_error = false;
}
