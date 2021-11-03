<?php
include "template/menu.php";



// cek tabel polling aktif
$check_active_polling = $show_polling->get_Query("SELECT * FROM list_table WHERE polling_active=1");
if (mysqli_num_rows($check_active_polling) != 0) {
    $name_active_polling = $show_polling->singleFetch($check_active_polling);
    $name_active_polling_s = $name_active_polling['name'];
}else{
    $name_active_polling_s = '-';
}

// tampilkan Settings 
$show_settings_sql = "SELECT * FROM dipolling_settings";
$result_settings_sql = $show_polling->get_Query($show_settings_sql);
$settings = $show_polling->singleFetch($result_settings_sql);

// Update gambar select Poll
if (isset($_POST['poll_img_submit'])) {

    // init class addMedia
    $dipMediaFotoExtension = ['jpg', 'png', 'jpeg'];
    $dipMedia = new dipollingMedia($_FILES, '../assets/img/', $dipMediaFotoExtension, 1000000);

    //upload gambar
    if ($_FILES['polimg']['name']) {
        unlink('../assets/img/' .  $_POST['old_icon']);
        
        $site_icon = $dipMedia->addMedia('img');
    }else{
        $site_icon = $_POST['old_icon'];
    }
    $dipolling->updateSelectPollImg($_POST, $site_icon);
    header("Location: dashboard");
}



// Query & Init Show All Table Item
$sql = "SELECT * FROM " . $name_active_polling_s;
$show_polling = new dipollingTable($db_host_name, $db_username, $db_password, $db_name);

// Result dari query Table Item
$result = $show_polling->get_Query($sql);
?>
    <div class="dib-admin-page-title fs-4 text-dark fw-bold">
        <i class="bi bi-speedometer2"></i> Dashboard
    </div>
    <div class="row d-flex justify-content-between">
        <div class="dip-admin-box mt-4 text-dark col-sm-4">
            <p class="text-dark">Total table</p>
            <span>
                <?php echo mysqli_num_rows($show_polling->get_Query("SELECT * FROM list_table"));?>
            </span>
        </div>
        <div class="dip-admin-box mt-4 text-dark col-sm-4">
            <p class="text-dark">Polling active <i class="bi bi-patch-check-fill text-success"></i></p>
            <span class="text-capitalize"><?= str_replace('_', ' ', $name_active_polling_s); ?></span>
            <div class="dip-float-total-polling">
                    <strong class="fs-3 d-block">
                        <?php
                    // Ambil total keseluruhan dari tabel polling target
                    $name_source_query = "SELECT SUM(polvote) FROM " . $name_active_polling_s;
                    // cek apakah $name_active_polling_s berisi string '-' atau nama tabel
                    // jika berisi nama tabel, tampilkan nama tabel tersebut
                        if ($name_active_polling_s !== "-") {
                            $res = $show_polling->get_Query($name_source_query);
                            // Show total polling
                            $single = $show_polling->singleFetch($res);
                            if($single == NULL){
                                echo 0;
                            }else {
                                echo $single['SUM(polvote)'];
                            }
                        }
                    ?>
                    </strong>
            </div>
        </div>
        <div class="dip-admin-box mt-4 text-dark col-sm-3">
            <p class="text-dark">Select Poll Image</p>
            <img src="../assets/img/<?= $setting['site_poll_icon']; ?>" alt="Poll Select Image" width="40px">
            <div class="dip-float-admin-box">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="input-group">
                        <input type="hidden" name="old_icon" value="<?= $setting['site_poll_icon']; ?>">
                        <input type="file" name="polimg" class="form-control" required>
                        <button type="submit" name="poll_img_submit" class="group-text btn btn-primary">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Chart From - chart.js -->
    <?php if($name_active_polling_s !== "-"): ?>
        <div style="width: 100%;height: 100%" class="mt-5 text-capitalize">
            <canvas id="dipChart"></canvas>
        </div>
    <script>
        var dipId = document.getElementById("dipChart").getContext('2d');
        var dipChart = new Chart(dipId, {
            type: 'bar',
            data: {
                
                labels: [
                <?php if($name_active_polling_s !== '-'): ?>
                <?php
                $rows_list_table = $show_polling->loopFetch($result);
                foreach ($rows_list_table as $row): ?>
                    <?= '"' . $row['polname'] . '"'; ?>,
                <?php endforeach; ?>]
                <?php endif; ?>,
                datasets: [{
                    label: <?= "'" . str_replace('_', ' ', $name_active_polling_s) . "'"; ?>,
                    data: [<?php foreach($rows_list_table as $row): ?><?php echo $row['polvote']; ?>,<?php endforeach; ?>],
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
    <?php else: ?>
    <div class="dip-empty-polling mt-5 mb-5">
        <img src="../assets/img/mg/undraw_no_data_re_kwbl.svg" alt="No data">
        <span class="fw-bold fs-4 text-secondary mt-3 d-block">No Polling activated</span>
    </div>
    <?php endif; ?>
<?php include "template/main.php"; ?>
