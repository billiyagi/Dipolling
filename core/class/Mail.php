<?php

class Mail{
     public function SetSendMailRecovery($receiver, $newRecoveryKey) {
          $from = $_SERVER['SERVER_NAME'];
          $result_url = homeUrl() . '/login?recovery=' . $newRecoveryKey;
          $to      = strip_tags( htmlspecialchars($receiver) );
          $subject = '[dipolling] - Forgot Password';
          $message = 'This is your recovery key, click it to recovery your account';
          $message .= "\n";
          $message .= "\n";
          $message .= $result_url;
          $headers = [
          'From' => 'noreply-dipolling@' . $from,
          'X-Mailer' => 'PHP/' . phpversion()
          ];

          $result_send = mail($to, $subject, $message, $headers);
          return $result_send;
     }
}
