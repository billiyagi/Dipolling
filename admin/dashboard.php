<?php
include "template/menu.php";

// cek tabel polling aktif
if ( mysqli_num_rows(  mysqli_query( DB::$conn, "SELECT * FROM dipolling_list_table WHERE polling_active=1" ) ) != 0 ) {
     // Fetch dan pilih polling mana yang aktif saat ini
     $activePolling = $showPolling->GetSingleFetch( "SELECT * FROM dipolling_list_table WHERE polling_active=1" );

     // Ambil nama dari row polling aktif
     $nameActivePolling = $activePolling['name'];

} else {
     // Jika polling tidak ada yang aktif
     $nameActivePolling = '-';
}

// Update gambar select Poll
if ( isset( $_REQUEST['poll_img_submit'] ) ) {

     // init class addMedia
     $mediaFile = new MediaFiles( $_FILES, ['../assets/img/', 'jpg', 'png', 'jpeg'], 1000000, 'polselectimg');

     //upload gambar
     if ( $_FILES['polselectimg']['name']) {

          if (  $siteIcon = $mediaFile->SetAddMedia( 'img') ) {
               // Hapus gambar lama
              unlink( '../assets/img/' .  $_REQUEST['old_icon']);

          } else {
               // Gunakan gambar lama
              $siteIcon = $_REQUEST['old_icon'];
          }

     } else {
          // Gunakan gambar lama
          $siteIcon = $_REQUEST['old_icon'];
     }

     // Init settings
     $NewSetting = new Settings( DB::$conn );

     // Update gambar select
     $NewSetting->SetUpdateSelectPollImg( $_REQUEST, $siteIcon );

     // Cek perubahan dalam database
     if ( mysqli_affected_rows( DB::$conn ) > 0 ) {
          header( "Location: dashboard?spoll=1" );

     } else {
         header( "Location: dashboard?spoll=0" );
     }
}

// Notifikasi Update gambar (Select Poll)
if ( isset( $_GET['spoll'] ) ) {

     if ( $_GET['spoll'] == 1 ) {
          echo ShowNotify( true, 'Image successfully changed' );

     } elseif ( $_GET['spoll'] == 0 ) {
          echo ShowNotify( false, 'Image failed to changed' );
     }
}

// Ganti tipe statistik
if ( isset($_REQUEST['submit_chart'] ) ) {
     setcookie( 'chart', $_REQUEST['chart'], time()+60*60*24*30 );
     header( "Location: dashboard" );
}

?>
    <div class="dib-admin-page-title fs-4 text-dark fw-bold">
        <i class="bi bi-speedometer2"></i> Dashboard
    </div>
    <div class="row d-flex justify-content-between">
        <div class="dip-admin-box mt-4 text-dark col-lg-4">
            <p class="text-dark">Total table</p>
            <span>
                 <!-- Total tabel yang ada di dalam database -->
                <?php echo mysqli_num_rows( mysqli_query( DB::$conn, "SELECT * FROM dipolling_list_table" ) );?>
            </span>
        </div>
        <div class="dip-admin-box mt-4 text-dark col-lg-4">
            <p class="text-dark">Polling active <i class="bi bi-patch-check-fill text-success"></i></p>
            <span class="text-capitalize"><?= str_replace('_', ' ', $nameActivePolling); ?></span>
            <div class="dip-float-total-polling">
                    <strong class="fs-3 d-block">
                        <?php
                              // Ambil total keseluruhan dari tabel polling target
                              // cek apakah $activePolling berisi string '-' atau nama tabel
                              // jika berisi nama tabel, tampilkan nama tabel tersebut
                        if ( $nameActivePolling !== "-" ) {
                              // Show total polling
                              $single = $showPolling->GetSingleFetch( "SELECT SUM(polvote) FROM " . $nameActivePolling );
                              if( $single == NULL ){
                                   echo 0;
                              } else {
                                   echo $single['SUM(polvote)'];
                              }
                        }
                    ?>
                    </strong>
            </div>
        </div>
        <div class="dip-admin-box mt-4 text-dark col-lg-3">
            <p class="text-dark">Select Poll Image</p>
            <img src="../assets/img/<?= $setting['site_poll_icon']; ?>" alt="Poll Select Image" width="40px">
            <div class="dip-float-admin-box">
                <form action="<?= PageSelf(); ?>" method="post" enctype="multipart/form-data" onsubmit="FormLoading()">
                    <div class="input-group">
                        <input type="hidden" name="old_icon" value="<?= $setting['site_poll_icon']; ?>">
                        <input type="file" name="polselectimg" class="form-control" required>
                        <button type="submit" name="poll_img_submit" class="group-text btn btn-primary">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Chart From - chart.js -->
     <div class="container-chart">
    <?php if ( $nameActivePolling !== "-" ): ?>
        <div style="width: 100%;height: 100%" class="mt-5 text-capitalize">
          <?php if ( $_COOKIE['chart'] == 'bar' || $_COOKIE['chart'] == 'line' ) : ?>
               <canvas id="dipChart" style="margin: 0"></canvas>
          <?php else : ?>
               <canvas id="dipChart" style="margin: auto"></canvas>
          <?php endif; ?>
        </div>
    <script>
        var dipId = document.getElementById("dipChart").getContext('2d');
        var dipChart = new Chart(dipId, {
            type: '<?php if(isset($_COOKIE['chart'])){
                 echo $_COOKIE['chart'];
            }else{
                 echo 'bar';
            } ?>',
            data: {

                labels: [
                <?php if( $nameActivePolling !== '-' ): ?>
                         <?php
                         // fetch semua item dengan key nama dari tabel yang aktif saat ini
                         $activeTableItem = $showPolling->GetLoopFetch( "SELECT * FROM " . $nameActivePolling );
                         foreach ( $activeTableItem as $row ):
                         ?>
                         <?= ' " ' . $row['polname'] . ' " '; ?>,
                     <?php endforeach; ?>]
                <?php endif; ?>,
                datasets: [{
                    label: <?= "'" . str_replace('_', ' ', $nameActivePolling) . "'"; // Nama Tabel ?>,
                    data: [<?php foreach ( $activeTableItem as $row ) : ?>
                         <?php echo $row['polvote']; ?>,
                         <?php endforeach; ?>],
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
   </div>
     <form action="<?= PageSelf(); ?>" method="post" class="mt-5 text-center" onsubmit="FormLoading()">
          <select class="" name="chart">
               <option value="Select Chart" disabled selected>Chart type</option>
               <option value="bar">Bar</option>
               <option value="line">Line</option>
               <option value="pie">Pie</option>
               <option value="radar">Radar</option>
               <option value="polarArea">Polar Area</option>
               <option value="doughnut">Doughnut</option>
          </select>
          <button type="submit" class="border-0 bg-primary text-light" name="submit_chart">Submit</button>
     </form>
    <?php else: ?>
    <div class="dip-empty-polling mt-5 mb-5">
        <img src="../assets/img/mg/undraw_no_data_re_kwbl.svg" alt="No data">
        <span class="fw-bold fs-4 text-secondary mt-3 d-block">No Polling activated</span>
    </div>
    <?php endif; ?>
<?php include "template/main.php"; ?>
