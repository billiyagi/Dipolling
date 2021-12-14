<?php
require 'template/menu.php';

$rowsSurvey = $showPolling->GetLoopFetch("SELECT * FROM dipolling_survey ORDER BY id DESC");

$rowsSettings = $showPolling->GetSingleFetch("SELECT * FROM dipolling_settings WHERE settings_profile='primary'");

if ( isset( $_REQUEST['submit_survey_template'] ) ) {
     $surveyTemplate = $_REQUEST['survey_template'];
     mysqli_query(DB::$conn, "UPDATE dipolling_settings SET survey_template='$surveyTemplate'");
     header("Location: surveys?notify=template_success&type=" . $_REQUEST['survey_template']);
}

// Notify
if ( isset( $_GET['notify'] ) ) {
     if ( $_GET['notify'] == "add_success" ) {
          echo ShowNotify(true, "Survey successfully added");

     } elseif ( $_GET['notify'] == "add_fail" ) {
          echo ShowNotify(false, "Survey failed to added");

     } elseif ( $_GET['notify'] == "delete_success" ) {
          echo ShowNotify(true, "Survey successfully deleted");

     } elseif ( $_GET['notify'] == "edit_success" ) {
          echo ShowNotify(true, "Survey successfully updated");

     } elseif ( $_GET['notify'] == "edit_fail" ) {
          echo ShowNotify(false, "Survey failed to updated");

     }elseif ( $_GET['notify'] == "template_success" ) {
          echo ShowNotify(true, "Template Survey " . $_GET['type']);

     }elseif ( $_GET['notify'] == "stop_status_1" ) {
          echo ShowNotify(true, "Survey was stopped");

     }elseif ( $_GET['notify'] == "stop_status_0" ) {
          echo ShowNotify(false, "Survey was stopped");

     }elseif ( $_GET['notify'] == "run_status_1" ) {
          echo ShowNotify(true, "Survey active again");

     }elseif ( $_GET['notify'] == "run_status_0" ) {
          echo ShowNotify(false, "Survey fail to activated");
     }
}
?>

<div class="dib-admin-page-title fs-4 text-dark fw-bold">
    <i class="bi bi-bar-chart-line"></i> Survey
</div>

<div class="btn-group">
<a href="survey?page=add" class="btn btn-lg btn-primary mb-4"><i class="bi bi-plus-circle"></i> Add Survey</a>

<!-- Survey Template Button -->
 <a href="#" class="btn btn-lg btn-success mb-4" data-bs-toggle="modal" data-bs-target="#surveyTemplate">Template</a>
</div>

 <!-- Survey Template Modal -->
 <div class="modal fade" id="surveyTemplate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
           <div class="modal-content">
                <div class="modal-body">
                    <h3 class="text-center mb-5">Survey Template</h3>
                    <form action="<?= PageSelf(); ?>" method="post" onsubmit="FormLoading()">
                         <div class="row w-100">
                              <?php if ($rowsSettings['survey_template'] === "top"): ?>
                                   <!-- Top -->
                                   <div class="col-lg-4">
                                        <label for="topText">
                                             <img src="../assets/img/mg/top-text.JPG" width="100%">
                                        </label>
                                        <input type="radio" name="survey_template" value="top" id="topText" checked> Top Text
                                   </div>

                                   <!-- Bottom -->
                                   <div class="col-lg-4">
                                        <label for="bottomText">
                                             <img src="../assets/img/mg/bottom-text.JPG" width="100%">
                                        </label>
                                        <input type="radio" name="survey_template" value="bottom" id="bottomText"> Bottom Text
                                   </div>

                                   <!-- Wrap -->
                                   <div class="col-lg-4">
                                        <label for="wrapText">
                                             <img src="../assets/img/mg/wrap-text.JPG" width="100%">
                                        </label>
                                        <input type="radio" name="survey_template" value="wrap" id="wrapText"> Wrap Text
                                   </div>
                              <?php elseif ( $rowsSettings['survey_template'] === "bottom" ): ?>
                                   <!-- Top -->
                                   <div class="col-lg-4">
                                        <label for="topText">
                                             <img src="../assets/img/mg/top-text.JPG" width="100%">
                                        </label>
                                        <input type="radio" name="survey_template" value="top" id="topText"> Top Text
                                   </div>

                                   <!-- Bottom -->
                                   <div class="col-lg-4">
                                        <label for="bottomText">
                                             <img src="../assets/img/mg/bottom-text.JPG" width="100%">
                                        </label>
                                        <input type="radio" name="survey_template" value="bottom" id="bottomText" checked> Bottom Text
                                   </div>

                                   <!-- Wrap -->
                                   <div class="col-lg-4">
                                        <label for="wrapText">
                                             <img src="../assets/img/mg/wrap-text.JPG" width="100%">
                                        </label>
                                        <input type="radio" name="survey_template" value="wrap" id="wrapText"> Wrap Text
                                   </div>
                              <?php elseif ( $rowsSettings['survey_template'] === "wrap" ) : ?>
                                   <!-- Top -->
                                   <div class="col-lg-4">
                                        <label for="topText">
                                             <img src="../assets/img/mg/top-text.JPG" width="100%">
                                        </label>
                                        <input type="radio" name="survey_template" value="top" id="topText"> Top Text
                                   </div>

                                   <!-- Bottom -->
                                   <div class="col-lg-4">
                                        <label for="bottomText">
                                             <img src="../assets/img/mg/bottom-text.JPG" width="100%">
                                        </label>
                                        <input type="radio" name="survey_template" value="bottom" id="bottomText"> Bottom Text
                                   </div>

                                   <!-- Wrap -->
                                   <div class="col-lg-4">
                                        <label for="wrapText">
                                             <img src="../assets/img/mg/wrap-text.JPG" width="100%">
                                        </label>
                                        <input type="radio" name="survey_template" value="wrap" id="wrapText" checked> Wrap Text
                                   </div>
                              <?php endif; ?>
                         </div>
                         <button type="submit" name="submit_survey_template" class="btn btn-lg btn-primary w-100 mt-4">Submit</button>
                    </form>
                </div>
           </div>
      </div>
 </div>


<?php if ( $rowsSurvey ): ?>
<div class="table-responsive">
     <table class="table">
     <tr class="bg-dark text-light">
          <th>
               No
          </th>
          <th>
               Survey
          </th>
          <th class="text-center">
               Answer
          </th>
          <th class="text-center">
               Link
          </th>
     </tr>
     <?php
     $i = 1;
     foreach ( $rowsSurvey as $row ) : ?>

     <tr>
          <td><?= $i; ?></td>
          <td>
               <?php if ( $row['survey_question'] && $row['survey_img'] == "" ): ?>
                    <?php
                    if (strlen($row['survey_question']) < 50) {
                         $result = $row['survey_question'];
                    }else{
                         $result = substr($row['survey_question'], 0, 50) . '...';
                    }
                    echo $result;
                    ?>
               <div class="d-flex dip-delete-item">
                    <a href="survey?page=edit&id=<?= $row['id']; ?>" class="me-2">Edit</a>
                    <a href="survey?page=survey_answer&id=<?= $row['id']; ?>" class="text-dark me-2">Answer</a>
                    <?php if ($row['survey_status'] == 1): ?>
                         <a href="survey?page=stop_survey&id=<?= $row['id']; ?>" class="me-2 text-secondary">Stop</a>
                    <?php else: ?>
                         <a href="survey?page=run_survey&id=<?= $row['id']; ?>" class="me-2 text-warning">Run</a>
                    <?php endif; ?>
                    <a href="survey?page=delete&id=<?= $row['id']; ?>" class="text-danger" onclick="return confirm('Are you sure?');">Delete</a>
               </div>
               <?php elseif ( $row['survey_img'] && $row['survey_question'] == "") : ?>

                    <!-- Survey Img button -->
                     <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#surveyImg<?= $row['id']; ?>">Img</a>

                     <!-- Survey Img Modal -->
                     <div class="modal fade" id="surveyImg<?= $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                               <div class="modal-content">
                                    <div class="modal-body">
                                        <img src="../assets/img/pollimg/<?= $row['survey_img']; ?>" alt="<?= $row['survey_img']; ?>" width="100%">
                                    </div>
                               </div>
                          </div>
                     </div>

                    <div class="d-flex dip-delete-item">
                         <a href="survey?page=edit&id=<?= $row['id']; ?>" class="me-2">Edit</a>
                         <a href="survey?page=survey_answer&id=<?= $row['id']; ?>" class="text-dark me-2">Answer</a>
                         <?php if ($row['survey_status'] == 1): ?>
                              <a href="survey?page=stop_survey&id=<?= $row['id']; ?>" class="me-2 text-secondary">Stop</a>
                         <?php else: ?>
                              <a href="survey?page=run_survey&id=<?= $row['id']; ?>" class="me-2 text-warning">Run</a>
                         <?php endif; ?>
                         <a href="survey?page=delete&id=<?= $row['id']; ?>" class="text-danger" onclick="return confirm('Are you sure?');">Delete</a>
                    </div>
               <?php else: ?>
                    <?php
                    if (strlen($row['survey_question']) < 50) {
                         $result = $row['survey_question'];
                    }else{
                         $result = substr($row['survey_question'], 0, 50) . '...';
                    }
                    echo $result;
                    ?>
                    <div class="d-flex dip-delete-item">
                         <a href="#" class="text-success me-2" data-bs-toggle="modal" data-bs-target="#surveyImg<?= $row['id']; ?>">Img</a>
                         <a href="survey?page=edit&id=<?= $row['id']; ?>" class="me-2">Edit</a>
                         <a href="survey?page=survey_answer&id=<?= $row['id']; ?>" class="text-dark me-2">Answer</a>
                         <?php if ($row['survey_status'] == 1): ?>
                              <a href="survey?page=stop_survey&id=<?= $row['id']; ?>" class="me-2 text-secondary">Stop</a>
                         <?php else: ?>
                              <a href="survey?page=run_survey&id=<?= $row['id']; ?>" class="me-2 text-warning">Run</a>
                         <?php endif; ?>
                         <a href="survey?page=delete&id=<?= $row['id']; ?>" class="text-danger" onclick="return confirm('Are you sure?');">Delete</a>
                    </div>

                    <!-- Add Polling Modal -->
                    <div class="modal fade" id="surveyImg<?= $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                         <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                              <div class="modal-content">
                                    <div class="modal-body">
                                        <img src="../assets/img/pollimg/<?= $row['survey_img']; ?>" alt="<?= $row['survey_img']; ?>" width="100%">
                                    </div>
                              </div>
                         </div>
                    </div>
               <?php endif; ?>
          </td>
          <td class="text-center">
               <?php
                    echo $totalSurveyAnswer = mysqli_num_rows(mysqli_query(DB::$conn, "SELECT * FROM dipolling_survey_answer WHERE survey_id=" . $row['id'] ) );
               ?>
          </td>
          <td class="text-center">
               <a href="<?= $res = str_replace('/admin' , '/survey/' , HomeUrl() . $row['survey_key']); ?>" title="Survey Link" target="_blank"><?= $row['survey_key']; ?></a>
          </td>
     </tr>

     <?php
     $i++;
     endforeach; ?>
</table>
</div>
<?php else: ?>
     <div class="m-auto">
          <div class="dip-empty-polling mt-5 mb-5">
              <img src="../assets/img/mg/undraw_no_data_re_kwbl.svg" alt="No data">
              <span class="fw-bold fs-4 text-secondary mt-3 d-block">Create your Survey Now!</span>
          </div>
     </div>
<?php endif; ?>
<?php require 'template/main.php'; ?>
