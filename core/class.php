<?php
class Dipolling{
    public $host,
           $username,
           $password,
           $db_name,
           $conn,
           $connect_errno,
           $connect_error;

    public function __construct($host, $username, $password, $db_name){
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->db_name = $db_name;
        $this->conn = mysqli_connect($host, $username, $password, $db_name);
        $this->connect_errno = mysqli_connect_errno();
        $this->connect_error = mysqli_connect_error();
    }
    public function add_table($query){
        mysqli_query($this->conn, $query);
        return mysqli_affected_rows($this->conn);
    }
    public function activatePolling($table_name){
        $result = mysqli_query($this->conn, "SELECT * FROM list_table WHERE name='$table_name'");
        $rows = mysqli_fetch_assoc($result);
        $id = $rows['id'];
        $name = $rows['name'];
        $active = 1;
        $query = "UPDATE list_table SET
                    name='$name',
                    polling_active=$active WHERE id=$id";
        mysqli_query($this->conn, $query);
        return mysqli_affected_rows($this->conn);
    }
}
class dipollingTable extends Dipolling{
    public $query_sql;

    public function get_Query($query){
        $this->query_sql = mysqli_query($this->conn, $query);
        return $this->query_sql;
    }

    public function loopFetch($result){
        $rows = [];
        while ($fetch = mysqli_fetch_assoc($result)) {
            $rows [] = $fetch;
        }
        return $rows;
    }
    public function singleFetch($result){
        $fetch = mysqli_fetch_assoc($result);
        return $fetch;
    }
}
class Notification extends Dipolling{
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
