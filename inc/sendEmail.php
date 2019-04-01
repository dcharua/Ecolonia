<?php

// Replace this with your own email address
$siteOwnersEmail = 'ron.ecolonia@gmail.com';


if($_POST) {

   $fname = trim(stripslashes($_POST['contactFname']));
   $lname = trim(stripslashes($_POST['contactLname']));
   $email = trim(stripslashes($_POST['contactEmail']));
   $subject = trim(stripslashes($_POST['contactSubject']));
   $contact_message = trim(stripslashes($_POST['contactMessage']));

   // Check First Name
	if (strlen($fname) < 2) {
		$error['fname'] = "Porfavor introduce tu nombre.";
	}
	// Check Last Name
	if (strlen($lname) < 2) {
		$error['lname'] = "Porfavor introduce tu apellido.";
	}
	// Check Email
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
		$error['email'] = "Porfavor introduce un email valido.";
	}
	// Check Message
	if (strlen($contact_message) < 5) {
		$error['message'] = "Porfavor escribe un mensaje con al menos 5 caracteres.";
	}
   // Subject
	if ($subject == '') { $subject = "Contact Form Submission"; }

	// Set Name
	$name = $fname . " " . $lname;

   // Set Message
   $message .= "Nombre: " . $name . "<br />";
	$message .= "Email: " . $email . "<br />";
    $message .= "Asunto: " . $subject . "<br />";
   $message .= "Mensaje: <br />";
   $message .= $contact_message;
   $message .= "<br /> ----- <br /> Este email fue enviado desde tu pagina web. <br />";

   // Set From: header
   $from =  $name . " <" . $email . ">";

   // Email Headers
	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $email . "\r\n";
 	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


   if (!$error) {

      ini_set("sendmail_from", $siteOwnersEmail); // for windows server
      $mail = mail($siteOwnersEmail, $subject, $message, $headers);

		if ($mail) { echo "OK"; }
      else { echo "Something went wrong. Please try again."; }
		
	} # end if - no validation error

	else {

		$response = (isset($error['fname'])) ? $error['fname'] . "<br /> \n" : null;
		$response .= (isset($error['lname'])) ? $error['lname'] . "<br /> \n" : null;
		$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
		$response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
		
		echo $response;

	} # end if - there was a validation error

}

?>