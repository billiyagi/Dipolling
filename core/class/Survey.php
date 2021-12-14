<?php
class Survey{

     protected $conn;

     public function __construct( $conn ) {
          $this->conn = $conn;
     }

     public function SurveyAnswerSubmit( $surveyFormId, $post ) {

          $surveyAnswer = strip_tags( htmlspecialchars( $_REQUEST['form_answer'] ) );
          $surveyAnswer = $post['survey_answer'];
          if ($surveyAnswer == "") {
               return false;
          }else{
               $surveyDate = date('F j, Y - g:i A');
               $sql = "INSERT INTO dipolling_survey_answer VALUES(NULL, $surveyFormId, '$surveyAnswer', '$surveyDate')";
               mysqli_query(DB::$conn, $sql);
               return true;
          }

     }


     public function SetAddSurvey($post, $img) {
          $surveyQuestion = htmlspecialchars($post['survey_question']);
          $key = strip_tags(htmlspecialchars($post['survey_link']));

          if ($surveyQuestion == "" && $img == "") {
               return "empty";
          }

          if ($key == "") {
               $key = RandomKey(5);
          }else{
               $key = str_replace(' ', '', $key);
          }

          $result = mysqli_query($this->conn, "INSERT INTO dipolling_survey VALUES( NULL, '$key', '$surveyQuestion', '$img', 1 )");
          return $result;
     }

     public function SetEditSurvey($post, $img) {
          $id = $post['id'];
          $surveyQuestion = htmlspecialchars($post['survey_question']);
          $key = strip_tags(htmlspecialchars($post['survey_link']));

          if ($key == "") {
               $key = RandomKey(5);
          }else{
               $key = str_replace(' ', '', $key);
          }

          if ( $post['delete_img'] == 'on' ) {
               $img = "";
               unlink("../assets/img/pollimg/" . $_REQUEST['old_surveyimgedit']);

          }elseif ( $post['delete_img'] != 'on' ) {
               // Ketika gambar tidak diganti
               if ( $_REQUEST['old_surveyimgedit'] != "" && $img == "") {
                    $img = $_REQUEST['old_surveyimgedit'];

               // Ketika gambar diganti
               }elseif ( $img ) {
                    unlink("../assets/img/pollimg/" . $_REQUEST['old_surveyimgedit']);
               }
          }

          $result = mysqli_query($this->conn, "UPDATE dipolling_survey
               SET survey_key='$key',
                   survey_question='$surveyQuestion',
                   survey_img='$img' WHERE id=$id");
          return $result;
     }
}
