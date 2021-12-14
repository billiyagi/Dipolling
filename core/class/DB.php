<?php
ob_start();

class DB{

    // Primary property
    private $host,
            $username,
            $password,
            $dbName,
            $connect_errno,
            $connect_error;

     // DB result Connection
     public static $conn,
                    $affected_rows;

    /*
    Primary function mengandung:
    - koneksi database (host, username, password, nama database)
    - cek koneksi error dengan mysqli_connect_errno
    - pesan kesalahan error dengan mysqli_connect_error
    */

    public function __construct($host, $username, $password, $dbName){
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbName = $dbName;
        $this->connect_errno = mysqli_connect_errno();
        $this->connect_error = mysqli_connect_error();
        static::$conn = mysqli_connect($host, $username, $password, $dbName);
        static::$affected_rows = mysqli_affected_rows(self::$conn);
    }
     public function connect_errno(){
          return $this->connect_errno;
     }
     public function affected_rows(){
          return $this->affected_rows;
     }
}

// Init
require 'Instalation.php';
require 'LoginSystem.php';
require 'MediaFiles.php';
require 'Polling.php';
require 'ShowFetch.php';
require 'Settings.php';
require 'Mail.php';
require 'Survey.php';
require 'Recovery.php';

ob_flush();
