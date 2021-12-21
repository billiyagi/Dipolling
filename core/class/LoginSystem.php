<?php

/*
ClassLoginSystem.php: Mengandung 1 class
- LoginSystem -> class yang berfungsi untuk membuat sistem login
*/

class LoginSystem{
     private $post,
             $conn;

     public function __construct($conn, $post){
            $this->conn = $conn;
            $this->post = $post;
     }

     public function LoginUser(){
          $loginUsername = htmlspecialchars($this->post['username']);
          $loginPassword = htmlspecialchars($this->post['password']);
          $query = "SELECT * FROM dipolling_users WHERE username='$loginUsername'";

          $result = mysqli_query($this->conn, $query);
          $fetch = mysqli_fetch_assoc($result);

          // cek username
          if (mysqli_num_rows($result) == 1) {

               // cek Password
               if ( password_verify($loginPassword, $fetch['password']) ) {
                    return true;
               }else{
                    // return kesalahan password
                    return 'password';
               }
          }else{
               // return kesalahan username
               return 'username';
          }
     }
     public function UpdateUser(){
          $update_email = htmlspecialchars($this->post['email']);
          $update_name = htmlspecialchars($this->post['name']);
          $update_username = htmlspecialchars($this->post['username']);
          // cek kekosongan password
          if ($this->post['password'] !== "") {
               // buat password baru
               $update_password = htmlspecialchars($this->post['password']);
               // enkripsi password
               $result_password = password_hash($update_password, PASSWORD_BCRYPT);
          }else{
               // gunakan password lama
               $result_password = $this->post['hashpw'];
          }
          $query = "UPDATE dipolling_users SET
                   email='$update_email',
                   name='$update_name',
                   password='$result_password' WHERE username='$update_username' ";

          $result = mysqli_query($this->conn, $query);
          return $result;
     }
}
