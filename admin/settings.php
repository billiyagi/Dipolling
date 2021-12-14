<?php
include "template/menu.php";

// init mail
$mail = new Mail(DB::$conn);

// tampilkan Settings
$settings = $showPolling->GetSingleFetch("SELECT * FROM dipolling_settings WHERE settings_profile='primary'");

if ( isset( $_REQUEST['submit'] ) ) {
     // Init Mediafile - Max file = 1,5mb
     $dipMedia = new MediaFiles($_FILES, '../assets/img/', ['jpg', 'png', 'jpeg'], 1500000, 'polimg');

     // kondisi ketika file telah ada atau tidak
     if ( $_FILES['polimg']['name'] ) {
        $site_icon = $dipMedia->SetAddMedia('img');
        if ($site_icon != false) {
             // Hapus file lama
             unlink('../assets/img/' .  $_REQUEST['old_icon']);
        }
     }else{
        $site_icon = $_REQUEST['old_icon'];
     }

     // Update settings
     $updateSettings = new Settings(DB::$conn);
     $updateSettings->SetUpdateSettings($_REQUEST, $site_icon);
     if ( mysqli_affected_rows( DB::$conn ) == 1 ) {
          header( "Location: settings?set=1" );
     }else{
          header( "Location: settings?set=0" );
     }

}

// Show Notif
if( isset( $_GET['set'] ) ) {
     if ( $_GET['set'] == 1 ) {
          echo ShowNotify( true, "Settings successfully updated" );
     }elseif( $_GET['set'] == 0 ) {
          echo ShowNotify( false, "Settings failed to updated" );
     }
}

?>

     <div class="dib-admin-page-title fs-4 text-dark fw-bold">
          <i class="bi bi-gear"></i> Settings
     </div>

     <!-- Settings Form -->
    <form action="<?= PageSelf(); ?>" method="post" enctype="multipart/form-data" onsubmit="FormLoading()">

          <input type="hidden" name="old_icon" value="<?= $settings['site_icon']; ?>">

          <div class="mb-3 row">
               <label for="webName" class="col-sm-4 col-form-label">Site Name</label>
               <div class="col-sm-8">
                    <input type="text" name="site_name" class="form-control" id="webName" placeholder="Enter your Site Name here" value="<?= $settings['site_name']; ?>" required>
               </div>
          </div>

          <div class="mb-3 row">
               <label for="iconWeb" class="col-sm-4 col-form-label">Site Icon <small class="text-secondary">( .jpg, .png, .jpeg )</small></label>

               <div class="col-sm-8">
               <input type="file" name="polimg" class="form-control" id="iconWeb">
                    <div class="dip-current-site-icon mt-3">
                         <img src="../assets/img/<?= $settings['site_icon']; ?>" alt="">
                         <label class="bg-dark text-light p-1 w-100 text-center">Current Site icon</label>
                    </div>
               </div>

          </div>
          <div class="mb-3 row">

               <label for="loginBtn" class="col-sm-4 col-form-label">Hide Login Button</label>

               <div class="col-sm-8 d-flex align-items-center">
                    <div class="form-check form-switch">
                    <?php if ($settings['site_hide_login'] > 0 ): ?>
                        <input name="site_hide_login" class="form-check-input" type="checkbox" role="switch" id="loginBtn" checked>
                    <?php else: ?>
                        <input name="site_hide_login" class="form-check-input" type="checkbox" role="switch" id="loginBtn">
                    <?php endif; ?>
                    </div>
               </div>

          </div>

          <div class="mb-3 row">

               <label for="loginBtn" class="col-sm-4 col-form-label">Maintenance</label>
               <div class="col-sm-8 d-flex align-items-center">
                    <div class="form-check form-switch">
                    <?php if ($settings['site_maintenance'] > 0 ): ?>
                        <input name="site_maintenance" class="form-check-input" type="checkbox" role="switch" id="loginBtn" checked>
                    <?php else: ?>
                        <input name="site_maintenance" class="form-check-input" type="checkbox" role="switch" id="loginBtn">
                    <?php endif; ?>
                    </div>
               </div>

          </div>
             <button type="submit" name="submit" class="btn btn-lg btn-primary mt-5"><i class="bi bi-check2-square"></i> Save Changes</button>
    </form>
<?php include "template/main.php"; ?>
