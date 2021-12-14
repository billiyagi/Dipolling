<?php
ob_start();
require_once 'core/server.php';

$showPolling = new ShowFetch(DB::$conn);

// ambil nama tabel yang kolom polling_active nya = 1
$pollingActiveSql = "SELECT * FROM dipolling_list_table WHERE polling_active=1";
$activePolling = $showPolling->GetSingleFetch($pollingActiveSql);

// cek polling yang sedang aktif atau tidak ada polling yang aktif
if (!empty($activePolling)) {

    //Jika $activePolling_s tidak NULL(kosong) result akan mengembalikan value dari fungsi loopFetch
    if (!empty($activePolling['name'])) {
        // Show Polling
        $showActivePollingSql = "SELECT * FROM " . $activePolling['name'];
        $rowsPollingActive = $showPolling->GetLoopFetch($showActivePollingSql);
    }
}
if (isset($activePolling['name'])) {
     $checkVotePoll = $showPolling->GetSingleFetch("SELECT SUM(polvote) FROM " . $activePolling['name']);

     if($checkVotePoll['SUM(polvote)'] == 0){
          setcookie('poll', '', time() - 3600);
     }
}

// ambil polling yang dipilih
if (isset($_POST['submit'])) {

     $setPollItem = new PollingItem($activePolling['name'], DB::$conn);

     // Menambahkan +1 ke dalam data row tabel yang dipilih
     $setPollItem->SetVoteItemPoll($_POST['poll']);

    $encryptPoll = base64_encode($activePolling['name']);
    // Cookie 1 hari
    setcookie('poll', $encryptPoll, time()+60*60*24);

    header("Location: index");
}

// Init Settings
$setting = $showPolling->GetSingleFetch("SELECT * FROM dipolling_settings WHERE settings_profile='primary'");

$self_page = explode('/', $_SERVER['PHP_SELF']);

$result_self_page = end($self_page);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Internal CSS -->
    <link rel="stylesheet" href="<?= HomeUrl() . '/assets/css/dipolling.css'; ?>">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= HomeUrl() . '/assets/css/bootstrap.min.css'; ?>">

    <!-- Bootstrap Icons -->
     <link rel="stylesheet" href="<?= HomeUrl() . '/assets/fonts/Bootstrap-Icon/bootstrap-icons.css'; ?>">

    <title><?= $setting['site_name']; ?></title>
    <link rel="icon" href="<?= HomeUrl() . '/assets/img/' . $setting['site_icon']; ?>" type="image/x-icon">
</head>
<body class="bg-light">

<div class="d-flex justify-content-center">
    <div class="dip-wd ps-4 pe-4">
        <?php if ($setting['site_hide_login'] > 0): ?>
            <header class="d-flex justify-content-center align-items-center pt-5 pb-5">
        <?php else: ?>
            <header class="d-flex justify-content-between align-items-center pt-5 pb-5">
        <?php endif ?>
            <span class="dip-brand text-decoration-none fs-2 text-secondary">
                <img src="<?= HomeUrl() . '/assets/img/' . $setting['site_icon']; ?>" alt="<?= $setting['site_name']; ?>" width="100px">
           </span>
            <?php if ($setting['site_hide_login'] > 0): ?>
            <?php else: ?>
                <a href="<?= HomeUrl() ?>/login" class="btn btn-lg btn-outline-dark">Login</a>
            <?php endif ?>
        </header>
        <main>
     <?php if ( isset($_GET['survey']) ): ?>
          <!-- Survey Page -->
          <?php

          $key_survey = $_GET['survey'];
          $survey =  $showPolling->GetSingleFetch("SELECT * FROM dipolling_survey WHERE survey_key='$key_survey'");

          // Submit Survey
          if ( isset( $_REQUEST['submit_survey'] ) ) {
                    $survey_submit = new Survey(DB::$conn);
               if ( $survey_submit->SurveyAnswerSubmit( $survey['id'], $_REQUEST ) ) {
                    header( "Location: " . PageSelf() );
               }else{
                    echo "<script>alert('Fill Survey')</script>";
               }
          }
          if ( !empty( $_GET['survey'] ) ): ?>

               <?php if ( !is_null( $survey ) ): ?>
                    <!-- Run Survey -->
                    <?php if ( $survey['survey_status'] == 1) : ?>

                         <!-- Top Template -->
                         <?php if ( $setting['survey_template'] == "top" ) : ?>
                              <div class="dip-survey mt-5">
                                   <h4 class="text-center mb-4 fs-3"><?= $survey['survey_question']; ?></h4>
                                   <?php if ( $survey['survey_img'] != "" ): ?>
                                        <img src="<?= HomeUrl() . '/assets/img/pollimg/' . $survey['survey_img']; ?>" width="100%" class="mb-4">
                                   <?php endif; ?>
                                   <form action="<?= HomeUrl() . '/survey/'; ?><?= $_GET['survey']; ?>" method="post">
                                        <textarea name="survey_answer" rows="15" placeholder="Write your answer" class="form-control" required></textarea>
                                        <button type="submit" name="submit_survey" class="btn btn-primary w-100 btn-lg mt-3 dip-none" id="btnSendSurvey" onclick="return confirm('Are you sure?')">Send</button>
                                   </form>
                              </div>

                         <!-- Bottom template -->
                         <?php elseif ( $setting['survey_template'] == "bottom" ) : ?>
                              <div class="dip-survey mt-5">
                                   <div class="position-relative mb-4">
                                   <?php if ( $survey['survey_img'] != "" ): ?>
                                        <img src="<?= HomeUrl() . '/assets/img/pollimg/' . $survey['survey_img']; ?>" width="100%">
                                        <div class="full-screen-img">
                                             <button type="button" class="w-100 position-absolute top-0 left-0 d-block h-100 mb-5" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                  <i class="bi bi-arrows-angle-expand text-light m-0"></i>
                                             </button>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                             <div class="modal-dialog modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg position-relative">
                                                  <div class="modal-content bg-transparent">
                                                       <img src="<?= HomeUrl() . '/assets/img/pollimg/' . $survey['survey_img']; ?>" class="w-100">
                                                       <button type="button" class="btn text-light position-absolute top-0 left-0 rounded-0" data-bs-dismiss="modal" style="z-index: 999999; background-color: rgba(0,0,0,.5);"><i class="bi bi-x fs-1"></i></button>
                                                  </div>
                                             </div>
                                        </div>
                                   <?php endif; ?>
                                   </div>
                                   <h4 class="text-center mb-4 fs-3"><?= $survey['survey_question']; ?></h4>
                                   <form class="" action="<?= HomeUrl() . '/survey/'; ?><?= $_GET['survey']; ?>" method="post">
                                        <textarea name="survey_answer" rows="15" placeholder="Write your answer" class="form-control" required></textarea>
                                        <button type="submit" name="submit_survey" class="btn btn-primary w-100 btn-lg mt-3 dip-none" id="btnSendSurvey" onclick="return confirm('Are you sure?')">Send</button>
                                   </form>
                              </div>

                         <!-- Wrap Template -->
                         <?php elseif ( $setting['survey_template'] == "wrap" ) : ?>
                              <div class="dip-survey mt-5 pt-5">
                                   <div class="position-relative mb-4">
                                        <?php if ( $survey['survey_img'] != "" ): ?>
                                             <img src="<?= HomeUrl() . '/assets/img/pollimg/' . $survey['survey_img']; ?>" width="100%" class="mb-4">

                                             <div class="full-screen-img">
                                                  <button type="button" class="w-100 position-absolute top-0 left-0 d-block h-100 mb-5" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                       <i class="bi bi-arrows-angle-expand text-light m-0"></i>
                                                  </button>
                                             </div>

                                             <!-- Modal -->
                                             <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                  <div class="modal-dialog modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg position-relative">
                                                       <div class="modal-content bg-transparent">
                                                            <img src="<?= HomeUrl() . '/assets/img/pollimg/' . $survey['survey_img']; ?>" class="w-100">
                                                            <button type="button" class="btn text-light position-absolute top-0 left-0 rounded-0" data-bs-dismiss="modal" style="z-index: 999999; background-color: rgba(0,0,0,.5);"><i class="bi bi-x fs-1"></i></button>
                                                       </div>
                                                  </div>
                                             </div>
                                        <?php endif; ?>
                                        <h4 class="text-center fs-3 position-absolute bottom-0 left-0 w-100 p-3 bg-dark text-light m-0"><?= $survey['survey_question']; ?></h4>
                                   </div>
                                   <form action="<?= HomeUrl() . '/survey/'; ?><?= $_GET['survey']; ?>" method="post">
                                        <textarea name="survey_answer" rows="15" placeholder="Write your answer" class="form-control" required></textarea>
                                        <button type="submit" name="submit_survey" class="btn btn-primary w-100 btn-lg mt-3 dip-none" id="btnSendSurvey" onclick="return confirm('Are you sure?')">Send</button>
                                   </form>
                              </div>
                         <?php endif; ?>
                    <?php else: ?>
                    <!-- Stop Survey -->
                         <div class="text-center mt-5 dip-not-found">
                              <img src="<?= HomeUrl() . '/assets/img/mg/undraw_Taken_if77.svg' ?>"; alt="Not Found">
                              <h4 class="text-dark mt-5 fs-3">Sorry, This Survey Has Been Stopped</h4>
                         </div>
                    <?php endif; ?>
               </main>
               <?php else : ?>
                    <div class="text-center mt-5 dip-not-found">
                         <img src="<?= HomeUrl() . '/assets/img/mg/undraw_page_not_found_su7k.svg' ?>"; alt="Not Found">
                         <h4 class="text-dark mt-4 fs-1 mb-4">Survey Not Found</h4>
                         <a href="<?= PageSelf() ?>">Back</a>
                    </div>
               <?php endif; ?>
          <?php endif; ?>
     <?php else: ?>
        <?php if ($setting['site_maintenance'] > 0): ?>
            <!-- Maintenance -->
            <div class="d-flex justify-content-center">
                <div class="dip-maintenance">
                    <img src="<?= HomeUrl() . '/assets/img/mg/undraw_not_found_-60-pq.svg'; ?>">
                    <p class="text-center mt-3 fs-2">We're not ready yet!</p>
                </div>
            </div>
        <?php else: ?>
            <!-- Container polling -->
            <div class="dip-container-pol dip-mt-6">
                <div class="dip-title-pol text-center">

               <?php if(!isset($_COOKIE['poll'])): ?>

                    <?php if (isset($activePolling['name'])): ?>

                        <h3 class="text-capitalize fw-bold">
                            <?php echo str_replace('_', ' ', $activePolling['name']); ?>
                        </h3>
                    <?php endif; ?>

               <?php endif; ?>

                </div>

                <!-- form polling -->
                <form action="" method="post">
                    <div class="mt-5 mb-5 row d-flex justify-content-center">
                    <?php if(!isset($activePolling['name'])): ?>
                        <img src="<?= HomeUrl() . '/assets/img/mg/undraw_well_done_i2wr.svg'; ?>" class="dip-welcome-polling">
                        <h2 class="text-center mt-5">Welcome to Dipolling!</h2>
                        <p class="text-center text-secondary">This main page to show your polling!</p>

                    <?php elseif(isset($_COOKIE['poll'])): ?>
                        <div class="text-center dip-thank-you">
                            <img src="<?= HomeUrl() . '/assets/img/mg/Balloons.gif'; ?>">
                            <h2>Thank you <br>for participating</h2>
                        </div>
                    <?php else: ?>

                        <?php foreach($rowsPollingActive as $row): ?>
                            <div class="col-lg-4 mt-4">
                                <!-- card polling -->
                                <div class="dip-card card shadow-sm border-0" id="ad">
                                    <img src="<?= HomeUrl() . '/assets/img/pollimg/' . $row['polimg']; ?>" alt="<?= $row['polname']; ?>" class="dip-cover-img boder-radius-top-1">
                                    <div class="card-title text-center pt-2 ps-1 pe-1 fs-5">
                                        <?= $row['polname']; ?>
                                    </div>
                                    <input class="dip-check" type="radio" name="poll" value="<?= $row['id']; ?>" id="rad_<?= $row['id']; ?>">
                                    <label for="rad_<?= $row['id']; ?>" onclick="btnSubmit()"></label>
                                    <img src="<?= HomeUrl() . '/assets/img/' . $setting['site_poll_icon']; ?>" alt="Check" class="dip-check-img dip-none">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                    <div id="submitVote">
                        <button type="submit" name="submit" class="btn btn-lg btn-primary d-block w-100 pt-3 pb-3 fs-4" onclick="return confirm('Apakah kamu yakin?')">Confirm</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
        </main>
     <?php endif; ?>
    </div>
</div>
<footer>
   <div class="powered-dipolling">
        <!-- Do Not remove this Copyright -->
        <small class="opacity-50 dip-no-mar">Powered by</small>
        <h1 class="text-secondary dip-brand opacity-50">Dipolling</h1>
   </div>
</footer>
<!-- Internal Javascript -->
<script src="<?= HomeUrl() . '/assets/js/dipolling.js'; ?>"></script>

<!-- JS Bootstrap -->
<script src="<?= HomeUrl() . '/assets/js/bootstrap.bundle.min.js'; ?>"></script>
<script src="<?= HomeUrl() . '/assets/js/bootstrap.min.js'; ?>"></script>

<!-- JS Jquery -->
<script src="<?= HomeUrl() . '/assets/js/jquery-3.4.1.slim.min.js'; ?>"></script>

<?php ob_flush(); ?>
</body>
</html>
