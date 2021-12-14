<?php
require 'template/menu.php';
$surveyAdmin = new Survey(DB::$conn);
$showSurvey = new ShowFetch(DB::$conn);
?>

<?php if ( isset( $_GET['page'] ) ): ?>

     <?php if ( $_GET['page'] != "" ): ?>

          <?php if ( $_GET['page'] == 'add' ) : ?>

               <?php
               // Submit Add Survey
               if (isset($_REQUEST['survey_add_submit'])) {

                    $dipMedia = new MediaFiles( $_FILES, '../assets/img/pollimg/', ['jpg', 'png', 'jpeg'], 1000000, 'surveyimgadd' );
                    $addImgItem = $dipMedia->SetAddMedia( 'img' );

                    if (!$addImgItem) {
                         $addImgItem = "";
                    }

                    // Upload File & add to database
                      if ( $addImgItem || $addImgItem == "" ) {
                              if ( $surveyAdmin->SetAddSurvey( $_REQUEST, $addImgItem) > 0 ) {
                                  header( "Location: surveys?notify=add_success" );
                             } else {
                                  header( "Location: surveys?notify=add_fail" );
                             }
                      } else {
                           // redirect
                           header( "Location: surveys?notify=add_fail" );
                      }
               }

               ?>

               <!-- Add Survey Page -->

               <div class="dib-admin-page-title fs-4 text-dark fw-bold">
                   <i class="bi bi-speedometer2"></i> Add Survey
               </div>

               <div id="helpSurveyQuestion">
               </div>

               <div id="helpSurveyLink">
               </div>

               <form action="<?= PageSelf(); ?>?page=add" method="post" enctype="multipart/form-data" onsubmit="FormLoading()">

                    <label for="survey_question" class="control-label mb-3">Survey Question
                         <a href="#" id="btnHelpSurveyQuestion" class="text-secondary" title="Help">
                              <i class="bi bi-question-circle"></i>
                         </a>
                    </label>

                    <input type="text" name="survey_question" class="form-control mb-3" id="survey_question" placeholder="Enter your question">

                    <label for="survey_link" class="control-label mb-3">Survey link
                         <a href="#" id="btnHelpSurveyLink" class="text-secondary" title="Help">
                              <i class="bi bi-question-circle"></i>
                         </a>
                    </label>

                    <input type="text" name="survey_link" class="form-control mb-4" id="survey_link" placeholder="Survey link (Optional)">

                    <label for="survey_img" class="control-label mb-3">Survey Img</label>
                    <input type="file" name="surveyimgadd" class="form-control mb-4" id="survey_img">

                    <button type="submit" name="survey_add_submit" class="btn btn-lg btn-primary">Submit Survey</button>
               </form>

               <script type="text/javascript">
               var alertPlaceholderSurveyQuestion = document.getElementById('helpSurveyQuestion')
               var alertTriggerSurveyQuestion = document.getElementById('btnHelpSurveyQuestion')

               var alertPlaceholderSurveyLink = document.getElementById('helpSurveyLink')
               var alertTriggerSurveyLink = document.getElementById('btnHelpSurveyLink')

               function alert(title, message, type) {
               var wrapper = document.createElement('div')
               wrapper.innerHTML = '<div class="alert alert-' + type + ' alert-dismissible" role="alert"><strong>' + title + '</strong> ' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'

               alertPlaceholderSurveyLink.append(wrapper)
               alertPlaceholderSurveyQuestion.append(wrapper)

               }

               if (alertTriggerSurveyQuestion) {
                    alertTriggerSurveyQuestion.addEventListener('click', function () {
                    alert('Survey Question', 'Membuat survey bisa hanya menggunakan teks, gambar ataupun keduanya.', 'secondary')
                    })
               }

               if ( alertTriggerSurveyLink ) {
                    alertTriggerSurveyLink.addEventListener('click', function () {
                    alert('Survey Link', 'Jika kolom link tidak di isi, maka sistem akan otomatis membuat link acak dengan 5 digit huruf dan Jangan gunakan spasi, sebagai gantinya gunakan underscore( _ ) atau dash ( - ).', 'secondary')
                    })
               }

               </script>

          <?php elseif ( $_GET['page'] == 'edit' ) : ?>
               <!-- Edit Survey Page -->

               <?php
               $id = $_GET['id'];
               $survey = $showSurvey->GetSingleFetch("SELECT * FROM dipolling_survey WHERE id=$id");

               // Submit Edit Survey
               if (isset($_REQUEST['survey_edit_submit'])) {

                    $dipMedia = new MediaFiles( $_FILES, '../assets/img/pollimg/', ['jpg', 'png', 'jpeg'], 1000000, 'surveyimgedit' );
                    $addImgItem = $dipMedia->SetAddMedia( 'img' );

                    if (!$addImgItem) {
                         $addImgItem = "";
                    }

                    // Upload File & add to database
                      if ( $addImgItem || $addImgItem == "" ) {
                           if ( $surveyAdmin->SetEditSurvey( $_REQUEST, $addImgItem) > 0 ) {
                             header( "Location: surveys?notify=edit_success" );
                           }
                      } else {
                           // redirect
                           header( "Location: surveys?notify=edit_fail" );
                      }
               }

               ?>

               <div class="dib-admin-page-title fs-4 text-dark fw-bold">
                   <i class="bi bi-bar-chart-line"></i> Edit Survey
               </div>

               <div id="helpSurveyQuestion">
               </div>

               <div id="helpSurveyLink">
               </div>

               <form action="<?= PageSelf(); ?>?page=edit" method="post" enctype="multipart/form-data" onsubmit="FormLoading()">

                    <input type="hidden" name="old_surveyimgedit" value="<?= $survey['survey_img']; ?>">
                    <input type="hidden" name="id" value="<?= $survey['id']; ?>">

                    <label for="survey_question" class="control-label mb-3">Survey Question
                         <a href="#" id="btnHelpSurveyQuestion" class="text-secondary" title="Help">
                              <i class="bi bi-question-circle"></i>
                         </a>
                    </label>
                    <input type="text" name="survey_question" class="form-control mb-3" id="survey_question" placeholder="Enter your question" value="<?= $survey['survey_question']; ?>">

                    <label for="survey_link" class="control-label mb-3">Survey link
                         <a href="#" id="btnHelpSurveyLink" class="text-secondary" title="Help">
                              <i class="bi bi-question-circle"></i>
                         </a>
                    </label>
                    <input type="text" name="survey_link" class="form-control mb-4" id="survey_link" placeholder="Survey link (Optional)" value="<?= $survey['survey_key']; ?>">
                    <label for="survey_img" class="control-label mb-3">Survey Img</label>
                    <input type="file" name="surveyimgedit" class="form-control mb-4" id="survey_img">

                    <?php if ($survey['survey_img'] != ""): ?>
                         <div class="dip-current-img mb-3" id="current-img">
                             <img src="../assets/img/pollimg/<?= $survey['survey_img']; ?>">
                             <label for="current-img" class="mt-3 bg-dark text-light w-100 p-2">Current Image</label>
                         </div>
                         <div class="d-flex mb-4">
                              <label for="deleteImg" class="control-label me-3">Delete Image </label>
                              <div class="form-check form-switch">
                                   <input name="delete_img" class="form-check-input" type="checkbox" role="switch" id="deleteImg">
                              </div>
                         </div>

                    <?php endif; ?>

                    <button type="submit" name="survey_edit_submit" class="btn btn-lg btn-primary">Submit</button>
               </form>

               <script type="text/javascript">
               var alertPlaceholderSurveyQuestion = document.getElementById('helpSurveyQuestion')
               var alertTriggerSurveyQuestion = document.getElementById('btnHelpSurveyQuestion')

               var alertPlaceholderSurveyLink = document.getElementById('helpSurveyLink')
               var alertTriggerSurveyLink = document.getElementById('btnHelpSurveyLink')

               function alert(title, message, type) {
               var wrapper = document.createElement('div')
               wrapper.innerHTML = '<div class="alert alert-' + type + ' alert-dismissible" role="alert"><strong>' + title + '</strong> ' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'

               alertPlaceholderSurveyLink.append(wrapper)
               alertPlaceholderSurveyQuestion.append(wrapper)

               }

               if (alertTriggerSurveyQuestion) {
                    alertTriggerSurveyQuestion.addEventListener('click', function () {
                    alert('Survey Question', 'Membuat survey bisa hanya menggunakan teks, gambar ataupun keduanya.', 'secondary')
                    })
               }

               if ( alertTriggerSurveyLink ) {
                    alertTriggerSurveyLink.addEventListener('click', function () {
                    alert('Survey Link', 'Jika kolom link tidak di isi, maka sistem akan otomatis membuat link acak dengan 5 digit huruf dan Jangan gunakan spasi, sebagai gantinya gunakan underscore( _ ) atau dash ( - ).', 'secondary')
                    })
               }

               </script>

          <?php elseif ( $_GET['page'] == 'delete' ) : ?>
               <!-- Delete Survey Page -->
               <?php
                    $id = $_GET['id'];
                    $survey = $showSurvey->GetSingleFetch("SELECT * FROM dipolling_survey WHERE id=$id");
                    unlink("../assets/img/pollimg/" . $survey['survey_img']);
                    mysqli_query(DB::$conn, "DELETE FROM dipolling_survey WHERE id=$id");
                    mysqli_query(DB::$conn, "DELETE FROM dipolling_survey_answer WHERE survey_id=$id");

                    unlink("../../assets/img/pollimg/" . $_REQUEST['old_surveyimgedit']);
                    header("Location: surveys?notify=delete_success");
               ?>

          <?php elseif ( $_GET['page'] == "stop_survey" ): ?>
               <!-- Stop Survey Page -->
               <?php
                    $id = $_GET['id'];
                    if ( mysqli_query(DB::$conn, "UPDATE dipolling_survey SET survey_status=0 WHERE id=$id") ) {
                         header("Location: surveys?notify=stop_status_1");
                    } else {
                         header("Location: surveys?notify=stop_status_0");
                    }
               ?>

          <?php elseif ( $_GET['page'] == "run_survey" ) : ?>
               <!-- Run Survey Page -->
               <?php
                    $id = $_GET['id'];
                    if ( mysqli_query(DB::$conn, "UPDATE dipolling_survey SET survey_status=1 WHERE id=$id") ) {
                         header("Location: surveys?notify=run_status_1");
                    } else {
                         header("Location: surveys?notify=run_status_0");
                    }
               ?>
          <?php elseif( $_GET['page'] == "survey_answer" ) : ?>
               <?php
                    $id = $_GET['id'];
                    $surveyTitle = $showSurvey->GetSingleFetch("SELECT * FROM dipolling_survey WHERE id=$id");
                    $surveyAnswer = $showSurvey->GetLoopFetch("SELECT * FROM dipolling_survey_answer WHERE survey_id=$id");
                    if ( is_null( $surveyTitle ) ) {
                         header("Location: surveys");
                    }
               ?>
               <div class="dib-admin-page-title fs-4 text-dark">
                   <span class="text-secondary">Survey : </span> <strong><?= $surveyTitle['survey_question']; ?></strong>
               </div>
               <hr>
               <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
               <?php if ( !empty( $surveyAnswer ) ) : ?>
                    <?php foreach ( $surveyAnswer as $answer ) : ?>
                         <div class="col">
                              <div class="card me-2 me-2 position-relative survey-answer-show h-100">
                                   <div class="card-body">
                                        <p class="card-text mb-5">
                                             <?php
                                             if (strlen($answer['survey_answer']) < 120) {
                                                  $result = $answer['survey_answer'];
                                             }else{
                                                  $result = substr($answer['survey_answer'], 0, 120) . '...';
                                             }
                                             echo $result;
                                             ?>
                                        </p>
                                        <small class="text-secondary position-absolute bottom-0 start-0 mb-2 ms-3"><?= $answer['survey_date']; ?></small>
                                   </div>
                                   <div class="position-absolute bottom-0 end-0 me-2 mb-2">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#surveyAnswer_<?= $answer['id'] ?>">More</button>
                                   </div>

                                    <!-- Add Polling Modal -->
                                   <div class="modal fade" id="surveyAnswer_<?= $answer['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                             <div class="modal-content p-3">
                                                  <p><?= $answer['survey_answer']; ?></p>
                                                  <small class="text-secondary"><?= $answer['survey_date']; ?></small>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>

                    <?php endforeach; ?>
               <?php else : ?>
                    <div class="d-flex justify-content-center align-items-center w-100" style="height: 50vh;">
                         <strong class="fs-1 text-secondary">No answer on this survey</strong>
                    </div>
               <?php endif; ?>
               </div>
          <?php else: ?>
               <?php header( "Location: surveys" ); ?>
          <?php endif; ?>

     <?php else: ?>
          <?php header( "Location: surveys" ); ?>
     <?php endif; ?>

<?php endif; ?>

<?php require 'template/main.php'; ?>
