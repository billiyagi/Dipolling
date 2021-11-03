<?php
require '../core/server.php';
$get_change_status_poll = $_GET['stat'];
echo $get_change_status_poll;
$get_name_poll = $_GET['name'];

if($dipolling->activatePolling($get_name_poll, $get_change_status_poll) > 0){
    header("Location: polling?activate=1&table_name=$get_name_poll");
}else{
    header("Location: polling?nonactivate=1&table_name=$get_name_poll");
}
