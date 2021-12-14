<?php
function RandomKey($j){
     $str = ["a","b","c","d","e",
             "f","g","h","i","j",
             "k","l","m","n","o",
             "p", "q", "r", "s", "t",
             "u", "v", "w", "x", "y", "z",
             "A", "B", "C", "D", "E", "F",
             "G", "H", "I", "J", "K", "L",
             "M", "N", "O", "P", "Q", "R",
             "S", "T", "U", "V", "W", "X",
             "Y", "Z"];
     $result = array_rand($str, $j);
     $key = [];
     $j -= 1;

     for ($i=0; $i <= $j; $i++) {

          // Key mentah dikumpulkan
          $key[] = $str[$result[$i]] . "";

          // Kondisi ketika loop berakhir
          if ($i == $j) {
               $results = '';

               // loop dan tampung ke $tampung, lalu dari $tampung satukan ke $results dan terus lakukan hingga loop selesai dilakukan.
               for ($m=0; $m <= $j; $m++) {
                    $tampung = $key[$m];
                    $results .= $tampung;
               }
          }
     }

     return $results;
}
function PageSelf(){
     if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
          $protocol = 'https://';
     }else{
          $protocol = 'http://';
     }
     return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
}
function HomeUrl(){
     $url = explode('/', PageSelf());
     array_pop($url);
     $resultUrl = implode('/', $url);
     return $resultUrl;
}
function ShowNotify($condition, $message){
    if (!$condition) {
       return '
       <div class="dip-notification shadow-lg dip-notif-show dip-notif-red" id="notif">
            <span>' . $message . '</span>
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
            <span>' . $message . '</span>
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
