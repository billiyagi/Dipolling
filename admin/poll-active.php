<?php
require "template/menu.php";
$changeStatusTable = $_GET['stat'];
$nameTable = $_GET['name'];
$dipolling = new Polling( $nameTable, DB::$conn );

if ( $dipolling->SetActivatePolling( $changeStatusTable ) > 0 ) {
    header( "Location: polling?activate=1&table_name=$nameTable" );
} else {
    header( "Location: polling?nonactivate=1&table_name=$nameTable" );
}
