<?php include "template/menu.php"; ?>
    <div class="dib-admin-page-title fs-4 text-dark fw-bold">
        <i class="bi bi-gear"></i> Settings
    </div>
    <form class="" action="index.html" method="post">
        <div class="mb-3 row">
            <label for="webName" class="col-sm-4 col-form-label">Site Name</label>
            <div class="col-sm-8">
            <input type="text" class="form-control" id="webName" placeholder="Enter your Site Name here">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="iconWeb" class="col-sm-4 col-form-label">Site Icon</label>
            <div class="col-sm-8">
            <input type="file" class="form-control" id="iconWeb">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="disabledSelect" class="col-sm-4 col-form-label">
                Smtp <button type="button" class="dip-btn-question" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  <i class="bi bi-question-circle"></i>
                </button>
            </label>
            <div class="col-sm-8 d-flex align-items-center">
                <select id="disabledSelect" class="form-select">
                  <option>Sendmail (PHP)</option>
                  <option>Sendinblue</option>
                  <option>Gmail</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="loginBtn" class="col-sm-4 col-form-label">Hide Login Button</label>
            <div class="col-sm-8 d-flex align-items-center">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="loginBtn">
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="displayMode" class="col-sm-4 col-form-label">Dark Mode</label>
            <div class="col-sm-8 d-flex align-items-center">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="displayMode">
                </div>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-lg btn-primary mt-5"><i class="bi bi-check2-square"></i> Save Changes</button>
    </form>

    <!-- Modal -->
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
            <p>smtp yang dimaksud Dipolling adalah server email yang akan mengirimkan kode recovery(pemulihan) ke pengguna dan ketika proses instalasi akun email pemulihan wajib di isi dan bebas menggunakan penyedia layanan email manapun, Dipolling menyediakan 3 cara untuk mengirimkan pesan email/surel ke pengguna. <br>diantara lain yaitu:</p>
            <ul>
                <li>
                    <h6 class="fw-bold">Sendmail (PHP)</h6>
                    <p>Untuk layanan ini pengguna harus mempunyai hosting dan domain sendiri yang mendukung fungsi php mail() untuk menggunakan mode ini.</p>
                </li>
                <li>
                    <h6 class="fw-bold">Gmail</h6>
                    <p>Ketika menggunakan smtp ini diharuskan pengguna juga menggunakan akun Google.</p>
                </li>
                <li>
                    <h6 class="fw-bold">Sendinblue</h6>
                    <p>Layanan smtp ini direkomendasikan untuk pengguna yang menggunakan email recoverynya dengan domain sendiri atau menggunakan penyedia layanan email lain, untuk menggunakan Sendinblue pengguna harus mengisi API Key milik pengguna pada saat proses instalasi atau ubah di file configurasi (<code>config.php</code>).</p>
                </li>
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
<?php include "template/main.php"; ?>
