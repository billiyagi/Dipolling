<?php
require "template/menu.php";
$nameTable = $_GET['table_name'];

$result = mysqli_query( DB::$conn, "SELECT * FROM dipolling_list_table WHERE name='$nameTable'" );

if ( mysqli_num_rows( $result ) == 1 ) {
     mysqli_query( DB::$conn, "UPDATE $nameTable SET polvote=0" );
     header( "Location: polling?reset=1&table_name=$nameTable" );
} else {
     header( "Location: polling?reset=0&table_name=$nameTable" );
}
