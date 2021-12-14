<?php

class Recovery {
     protected $conn;

     public function __construct($conn) {
          $this->conn = $conn;
     }

     public function SetMakeRecovery($email, $key) {
          $query = "INSERT INTO dipolling_mail_recovery VALUES(NULL, '$email', '$key')";
          $result = mysqli_query($this->conn, $query);
          return $result;
     }

     public function SetRecoveryPassword($post) {
          $password = password_hash($post['password_recovery'], PASSWORD_BCRYPT);
          $mail = $post['mail'];

          // Update user password
          $queryUpdatePassword = "UPDATE dipolling_users SET password='$password' WHERE email='$mail'";
          $resultUpdatePassword = mysqli_query($this->conn, $queryUpdatePassword);

          // Delete key after password change
          $queryDelete = "DELETE FROM dipolling_mail_recovery WHERE email='$mail'";
          $resultDelete = mysqli_query($this->conn, $queryDelete);
          return $resultDelete;
     }
}
