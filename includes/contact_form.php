<?php

$name = $email = $subject = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name     = test_input($_POST["name"]);
  $email    = test_input($_POST["email"]);
  $email    = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
  $subject  = test_input($_POST["subject"]);
  $msg      = test_input($_POST["message"]);
  $msg     .= wordwrap($message,70);


  if($email){
    $to        = 'davidburkegaskin@gmail.com';
    $from      = 'ContactUs@songfarm.ca';
    $from_name = $name;
    $message   = 'From: ' . $from_name . "\r\n\r\n";
    $message  .= $msg;
    $headers   = "From: $from\r\nReply-to: $email";
    $result    = mail($to, $subject, $message, $headers);
    if($result){
      echo 'Thanks for getting in touch!';
    }else{
      echo 'We\'re sorry but there was a problem submitting the contact form. Please try again later.';
    }
  }
}

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  //
  // $result = mail($to, $subject, $message, "From: " . $name . ' ' . '<' . $email . '>');
  //
  // if($result){
  //   echo 'Success';
  // } else {
  //   echo 'nope';
  // }
  // $mail = new PHPMailer;
  // $mail->isSMTP();

  // Shows error messages:
    // $mail->SMTPDebug    = 2;
    // $mail->Debugoutput  = 'html';

  // Gmail settings -  This works with Localhost!
    // $mail->Host         = 'smtp.gmail.com';
    // $mail->Port         = 587; // 25 for hotmail
    // $mail->SMTPSecure   = 'tls'; // ssl or tls
    // $mail->Username     = "davidburkegaskin@gmail.com";
    // $mail->Password     = "Parlophone3";

  // $mail->Host         = 'relay-hosting.secureserver.net';
  // $mail->Port         = 25;
  // $mail->SMTPSecure   = false;
  // $mail->SMTPAuth     = false;
  //
  //
  // $from_name  = $name;
  // $from       = $email;
  // $to_name    = "ContactUs@Songfarm.ca";
  // $to         = "davidburkegaskin@gmail.com";
  // $subject    = $sbj . strftime("%T",time());
  // $message    = $msg;
  // $message    = wordwrap($msg,70);
  //
  // $mail->FromName = $from_name;
  // $mail->From			= $from;
  // $mail->AddAddress($to, $to_name);
  // $mail->Subject	= $subject;
  // $mail->Body 		= $message;
  //
  // $result = $mail->Send();
  // echo $result ? 'Sent' : $mail->ErrorInfo;
  // // create an on page alert if there's an error
  // echo $from_name . " " . $from;



 ?>
