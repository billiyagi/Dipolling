<?php

/*
ClassPolling.php: Mengandung 2 class
- Polling -> class yang mengurus tabel polling seperti mengaktifkan/menonaktifkan tabel vote
- PollingItem -> class yang mengurus isi pada tabel polling seperti mengedit, menambah
  dan menghapus data isi polling
*/

class Polling{
     private $conn,
             $tableName;

     public function __construct( $tableName, $conn ){
          $this->conn = $conn;
          $this->tableName = $tableName;
     }

     /*
     Mengaktifkan / Menonaktifkan Tabel polling dengan
     membutuhkan parameternya nama tabel dan status tabel
     */
     public function SetActivatePolling( $status ){
         $tableName = $this->tableName;
         $result = mysqli_query( $this->conn, "SELECT * FROM dipolling_list_table WHERE name='$tableName'" );
         $rows = mysqli_fetch_assoc( $result );
         $id = $rows['id'];
         $name = $rows['name'];

         // Cek kondisi status parameter polling
         if( isset($status) ){
            if ( $status == 'active' ) {
                 $active = 1;
            }elseif( $status == 'nonactive' ){
                 $active = -1;
            }
         }
         $sql = "UPDATE dipolling_list_table SET
                     name='$tableName',
                     polling_active=$active
                     WHERE id=$id";
         mysqli_query( $this->conn, $sql );
         return $active;
     }

     // Menghapus Tabel
     public function SetDropTable( $query ){
         $result = mysqli_query( $this->conn, $query );
         return 1;
     }
     public function SetTablePolling( $query ){
          $result = mysqli_query( $this->conn, $query );
          return $result;
     }
}
class PollingItem{
     private $conn,
             $tableName;

     public function __construct( $tableName, $conn ){
          $this->conn = $conn;
          $this->tableName = $tableName;
     }

     // Menambahkan Jumlah suara(vote) di dalam tabel data
     public function SetVoteItemPoll( $id ){
          $tableName = $this->tableName;
          $sql = "UPDATE $tableName SET polvote= polvote + 1 WHERE id=$id";
          $result = mysqli_query( $this->conn, $sql );
          return mysqli_affected_rows( $this->conn );
     }

     // Menambahkan item yang akan di gunakan untuk menyimpan dan menampilkan
     public function SetAddItemPoll( $get_post, $polimg ){
          $tableName = $this->tableName;
          $polname = $get_post['polname'];
          if ( $polimg ) {
               $sql = "INSERT INTO $tableName VALUES( NULL, '$polimg', '$polname', 0 )";
               $result = mysqli_query( $this->conn, $sql );
               return mysqli_affected_rows($this->conn);
          }else{
               return false;
          }
     }

     // edit item polling
     public function SetEditItemPoll( $get_post, $polimg ){
          $tableName = $this->tableName;
          $polid = $get_post['polid'];
          $polname = $get_post['polname'];

          // jika gambar baru kosong berikan file gambar lama
          if ( $polimg == false ) {
            $polimg = $get_post['oldpolimg'];
          }

          $sql = "UPDATE $tableName SET
                 id='$polid',
                 polname='$polname',
                 polimg='$polimg' WHERE id='$polid' ";
          $result = mysqli_query( $this->conn, $sql );
     }
}
