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
    public function add_table($query, $mode){
        mysqli_multi_query($this->conn, $query);
        return mysqli_affected_rows($this->conn);
        // if($mode == 'single'){
        //     mysqli_query($this->conn, $query);
        //     return mysqli_affected_rows($this->conn);
        // }elseif($mode == 'multi'){
        //
        //     mysqli_multi_query($this->conn, $query);
        //     return mysqli_affected_rows($this->conn);
        // }
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
