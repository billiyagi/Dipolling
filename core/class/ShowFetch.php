<?php

/*
ClassShowFetch.php: Mengandung 1 class
- PollingFetch -> class yang mengurus untuk mengambil data pada database dan
  membungkusnya dengan array
*/

class ShowFetch{
    private $conn;

    public function __construct($conn){
         $this->conn = $conn;
    }

    // Eksekusi untuk menghapus item atau tabel
    public function SetDeleteFetch($query){
        mysqli_query($this->conn, $query);
    }

    // Perulangan Fetch array assosiatif
    public function GetLoopFetch($query){
          $result = mysqli_query($this->conn, $query);
          $rows = [];
          while ($fetch = mysqli_fetch_assoc($result)) {
            $rows [] = $fetch;
          }
          return $rows;
    }

    // Single Fetch array assosiatif
    public function GetSingleFetch($query){
          $result = mysqli_query($this->conn, $query);
          $fetch = mysqli_fetch_assoc($result);
          return $fetch;
    }
}
