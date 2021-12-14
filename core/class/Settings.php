<?php

/*
ClassSettings.php: Mengandung 1 class
- Settings -> class yang mengurus untuk mengubah settings dan select poll IMG
*/

class Settings{
     private $conn;

     public function __construct($conn){
          $this->conn = $conn;
     }

     // settings
     public function SetUpdateSettings($post, $siteIcon){

         $siteName = $post['site_name'];
         $siteHideLogin = $post['site_hide_login'];
         $siteMaintenance = $post['site_maintenance'];
          if ($siteName == "") {
               return false;
          }

          //jika $siteIcon kosong berarti tidak update icon
          if ($siteIcon == "") {
               $siteIcon = $post['old_icon'];
          }

          if (isset($siteHideLogin)) {
            $siteHideLogin = 1;
          }else{
            $siteHideLogin = -1;
          }
          if (isset($siteMaintenance)) {
            $siteMaintenance = 1;
          }else{
            $siteMaintenance = -1;
          }
         $sql = "UPDATE dipolling_settings SET
                 site_name='$siteName',
                 site_icon='$siteIcon',
                 site_hide_login=$siteHideLogin,
                 site_maintenance=$siteMaintenance WHERE settings_profile='primary'";
         return mysqli_query($this->conn, $sql);
     }

     public function SetUpdateSelectPollImg($post, $site_icon){
          $old_icon = $post['old_icon'];

          if ($site_icon == false) {
            $site_icon = $post['old_icon'];
          }
          $sql = "UPDATE dipolling_settings SET
                 site_poll_icon='$site_icon' WHERE settings_profile='primary'";
          mysqli_query($this->conn, $sql);
     }
}
