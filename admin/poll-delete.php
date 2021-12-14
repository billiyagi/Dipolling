<?php
require "template/menu.php";

$tableName = $_GET['name'];

// Fetch isi tabel
$rowsItem = $showPolling->GetLoopFetch( "SELECT * FROM $tableName" );

// Hapus satu persatu gambar
if ( !empty( $rowsItem ) ) {
     foreach ( $rowsItem as $row ) {
         unlink( '../assets/img/pollimg/' . $row['polimg'] );
     }
}

// Hapus tabel
mysqli_query( DB::$conn, "DROP TABLE " . $tableName );

// Hapus field tabel di dipolling_list_table
mysqli_query( DB::$conn, "DELETE FROM dipolling_list_table WHERE name='$tableName'" );

// redirect
if ( mysqli_affected_rows( DB::$conn ) == 1 ) {
     header( "Location: polling?table_name=$tableName&table_delete=1" );
}else{
     header( "Location: polling?table_name=$tableName&table_delete=0" );
}
