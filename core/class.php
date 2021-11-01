<?php
class Dipolling{

    // Primary property
    public $host,
           $username,
           $password,
           $db_name,
           $conn,
           $connect_errno,
           $connect_error;

    /*
    Primary function mengandung:
    - koneksi database (host, username, password, nama database)
    - cek koneksi error dengan mysqli_connect_errno
    - pesan kesalahan error dengan mysqli_connect_error
    */
    public function __construct($host, $username, $password, $db_name){
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->db_name = $db_name;
        $this->conn = mysqli_connect($host, $username, $password, $db_name);
        $this->connect_errno = mysqli_connect_errno();
        $this->connect_error = mysqli_connect_error();
    }

    // Menambahkan tabel polling dengan membutuhkan parameternya queri SQL
    public function add_table($query){
        mysqli_query($this->conn, $query);
        return mysqli_affected_rows($this->conn);
    }

    /* Mengaktifkan / Menonaktifkan Tabel polling dengan membutuhkan parameternya nama tabel dan status tabel */
    public function activatePolling($table_name, $status){
        $result = mysqli_query($this->conn, "SELECT * FROM list_table WHERE name='$table_name'");
        $rows = mysqli_fetch_assoc($result);
        $id = $rows['id'];
        $name = $rows['name'];

        // Cek kondisi status parameter polling
        if(isset($status)){
            if ($status == 'active') {
                $active = 1;
            }elseif($status == 'nonactive'){
                $active = -1;
            }
        }
        $query = "UPDATE list_table SET
                    name='$name',
                    polling_active=$active
                    WHERE id=$id";
        mysqli_query($this->conn, $query);
        return $active;
    }

    // Menambahkan Jumlah suara(vote) di dalam tabel data
    public function VotePoll($table_name, $id_vote){
        $result = mysqli_query($this->conn, "UPDATE $table_name SET polvote= polvote + 1 WHERE id=$id_vote");
        return mysqli_affected_rows($this->conn);
    }

    // Menambahkan item yang akan di gunakan untuk menyimpan dan menampilkan
    public function addItemPoll($table_name, $get_post, $polimg){
        $polname = $get_post['polname'];
        $sql = "INSERT INTO $table_name VALUES(NULL, '$polimg', '$polname', 0)";
        $result = mysqli_query($this->conn, $sql);
    }
}
class dipollingMedia extends Dipolling{
    public $files,
           $directory,
           $extension,
           $size;

    public function __construct($files, $directory, $extension, $size){
        $this->files = $files;
        $this->directory = $directory;
        $this->extension = $extension;
        $this->size = $size;
    }

    /*
    method addMedia berfungsi untuk membuat nama file baru dan memindahkannya ke folder tujuan, dengan membutuhkan parameter $type (tipe yang akan di inputkan) cth:
    img = tipe file gambar/foto (jpg, png, gif, dll..) sesuai inputan dari construc
    vid = tipe file video/rekaman (mp4, 3gp, mkv, dll..) sesuai inputan dari construc
    */
    public function addMedia($type){
        if ($type == 'img') {
            $file = $this->files;
            // ambil data dan pisahkan ke beberapa bagian
            // property dari $_FILES
            $file_name = $file['polimg']['name'];
            $file_type = $file['polimg']['type'];
            $file_tmp = $file['polimg']['tmp_name'];
            $file_error = $file['polimg']['error'];
            $file_size = $file['polimg']['size'];

            //property dari settings query
            $get_directory = $this->directory;
            $get_extension = $this->extension;
            $get_max_size = $this->size;

            // cek file apakah kosong atau tidak
            if ($file_error === 4) {
                return 'ksong';
            }

            // cek ekstensi upload
            $result_extension = explode('.', $file_name);
            $result_extension = strtolower(end($result_extension));
            if (!in_array($result_extension, $get_extension)) {
                return 'extensi';
            }

            // cek ukuran file
            if ($file_size > $get_max_size) {
                return 'size';
            }

            // Buat Nama File baru
            $final_result_extension = uniqid();
            $final_result_extension .= '.';
            $final_result_extension .= $result_extension;

            // gambar dipindahkan ke folder tujuan dengan nama file baru
            move_uploaded_file($file_tmp, $get_directory . $final_result_extension);

            // kembalikan nilai ke result file
            return $final_result_extension;

        }
        // return $this->result_files = $final_result_extension;
        return $final_result_extension;
    }
}
class dipollingTable extends Dipolling{
    public $query_sql;

    // Query SQL
    public function get_Query($query){
        $this->query_sql = mysqli_query($this->conn, $query);
        return $this->query_sql;
    }

    // Menghapus Tabel
    public function dropTable($query){
        $result = mysqli_query($this->conn, $query);
        return 1;
    }

    // Menghapus fetch
    public function deleteFetch($query){
        mysqli_query($this->conn, $query);
        return $this->query_sql;
    }

    // Perulangan Fetch array assosiatif
    public function loopFetch($result){
        $rows = [];
        while ($fetch = mysqli_fetch_assoc($result)) {
            $rows [] = $fetch;
        }
        return $rows;
    }

    // Single Fetch array assosiatif
    public function singleFetch($result){
        $fetch = mysqli_fetch_assoc($result);
        return $fetch;
    }
}
class Notification extends Dipolling{
    // Notifikasi red & green
    public function showNotify($condition, $message){
        if (!$condition) {
            return '
            <div class="dip-notification shadow-lg dip-notif-show dip-notif-red" id="notif">
                <span><strong>Error:</strong> ' . $message . '</span>
            </div>
            <script type="text/javascript">
                function closeNotif(){
                    document.getElementById("notif").classList.remove("dip-notif-show");
                }

                 window.setTimeout( closeNotif, 7000 );
            </script>
            ';
        }else{
            return '
            <div class="dip-notification shadow-lg dip-notif-show dip-notif-green" id="notif">
                <span><strong>Success:</strong> ' . $message . '</span>
            </div>
            <script type="text/javascript">
                function closeNotif(){
                    document.getElementById("notif").classList.remove("dip-notif-show");
                }

                 window.setTimeout( closeNotif, 7000 );
            </script>
            ';
        }
    }
}
