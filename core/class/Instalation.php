<?php

/*
ClassInstalation.php: Mengandung 1 class
- Instalation -> class yang mengurus Instalasi seperti membuat tabel dan menambah item di tabel
*/

class Instalation{
     private $conn,
             $affected_rows;

     public function __construct( $conn ){
          $this->conn = $conn;
     }

     // Add user from instalation
     public function SetUserInstall( $post ){
         $name_account = htmlspecialchars( $post['name_account'] );
         $email_account = htmlspecialchars( $post['email_account'] );
         $username_account = htmlspecialchars( $post['username_account'] );
         $password_account = htmlspecialchars( $post['password_account'] );

         // Enkripsi
         $result_password = password_hash( $password_account, PASSWORD_BCRYPT );

         $query_account = "INSERT INTO dipolling_users VALUES( NULL, '$email_account', '$name_account' ,'$username_account', '$result_password' )";

          mysqli_query( $this->conn, $query_account );
          return true;
     }

     // Set settings
     public function SetSettingsInstall( $post, $icon ){
         $siteName = $post['site_name'];
         $siteSMTP = $post['site_smtp'];
         $min = -1;
         $sqlSettings = "INSERT INTO dipolling_settings VALUES( 'primary', '$siteName', '$icon', '$siteSMTP', 'ok.png', 'top', $min, $min )";

          mysqli_query( $this->conn, $sqlSettings );
          return true;
     }

     // Menambahkan tabel polling dengan membutuhkan parameternya queri SQL
     public function SetTableInstall( $query ){
         mysqli_query( $this->conn, $query );
         return $this->affected_rows;
     }
}
