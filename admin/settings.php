<?php 
include "template/menu.php";

// tampilkan Settings 
$show_settings_sql = "SELECT * FROM dipolling_settings";
$result_settings_sql = $show_polling->get_Query($show_settings_sql);
$settings = $show_polling->singleFetch($result_settings_sql);


if (isset($_POST['submit'])) {

    $dipMediaFotoExtension = ['jpg', 'png', 'jpeg'];
    $dipMedia = new dipollingMedia($_FILES, '../assets/img/', $dipMediaFotoExtension, 1000000);

    if ($_FILES['polimg']['name']) {
        unlink('../assets/img/' .  $_POST['old_icon']);
        
        $site_icon = $dipMedia->addMedia('img');
    }else{
        $site_icon = $_POST['old_icon'];
    }
    $dipolling->updateSettings($_POST, $site_icon);
    header("Location: settings.php");
}

?>



    <div class="dib-admin-page-title fs-4 text-dark fw-bold">
        <i class="bi bi-gear"></i> Settings
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="old_icon" value="<?= $settings['site_icon']; ?>">
        <div class="mb-3 row">
            <label for="webName" class="col-sm-4 col-form-label">Site Name</label>
            <div class="col-sm-8">
            <input type="text" name="site_name" class="form-control" id="webName" placeholder="Enter your Site Name here" value="<?= $settings['site_name']; ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="iconWeb" class="col-sm-4 col-form-label">Site Icon</label>
            <div class="col-sm-8">
            <input type="file" name="polimg" class="form-control" id="iconWeb">
            <div class="dip-current-site-icon mt-3">
                <img src="../assets/img/<?= $settings['site_icon']; ?>" alt="">
                <label class="bg-dark text-light p-1 w-100 text-center">Current Site icon</label>
            </div>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="smtpWeb" class="col-sm-4 col-form-label">
                Smtp <button type="button" class="dip-btn-question" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  <i class="bi bi-question-circle"></i>
                </button>
            </label>
            <div class="col-sm-8 d-flex align-items-center">
                <input type="url" name="site_api_smtp" class="form-control" placeholder="smtp" id="smtpWeb" value="<?= $settings['site_smtp']; ?>" disabled>
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

    <!-- Modal SMTP Guide -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Panduan Smtp</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h4 class="fw-bold">Apa itu smtp?</h4>
            <p>Simple Mail Transfer Protocol adalah standar Internet untuk transmisi email. Pertama kali didefinisikan oleh RFC 821 pada tahun 1982, diperbarui pada 2008 dengan penambahan SMTP yang diperluas oleh RFC 5321; yang merupakan protokol yang digunakan secara luas saat ini. <a href="https://id.wikipedia.org/wiki/Simple_Mail_Transfer_Protocol">Wikipedia</a></p>
            <br>
            <br>
            <p class="fw-bold fs-5">apa yang dimaksud smtp di <span class="dip-brand fs-5 text-secondary">Dipolling</span> ?</p>
            <p>smtp yang dimaksud Dipolling adalah server email yang akan mengirimkan kode recovery(pemulihan) ke pengguna dan ketika proses instalasi akun email pemulihan wajib di isi dan bebas menggunakan penyedia layanan email manapun, dan saat ini Dipolling hanya menerima smtp dari sendinblue untuk pemulihan akun sedang dalam pengembangan. ikuti perkembangannya di <a href="https://github.com/gobillyx/Dipolling">Github</a></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
<?php include "template/main.php"; ?>
