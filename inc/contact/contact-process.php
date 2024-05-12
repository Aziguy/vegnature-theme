<?php
$address = "vegnature@vegnature.fr";
if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

$error = false;
$fields = array( 'name', 'email', 'message' );

foreach ( $fields as $field ) {
	if ( empty($_POST[$field]) || trim($_POST[$field]) == '' )
		$error = true;
}

if ( !$error ) {
	$name = stripslashes($_POST['name']);
	$email = trim($_POST['email']);	
	$subject = stripslashes($_POST['subject']);
	$message = stripslashes($_POST['message']);
	$e_subject = 'Vous avez été contacté par ' . $name . '.';
	

	// Configuration option.
	// You can change this if you feel that you need to.
	// Developers, you may wish to add more fields to the form, in which case you must be sure to add them here.

	$e_body = "Vous avez été contacté par : $name" . PHP_EOL . PHP_EOL;
	$e_reply = "E-mail: $email" . PHP_EOL . PHP_EOL;
	$e_content = "Message:\r\n$message \r\n Noms: $name \r\n Objet: $e_subject" . PHP_EOL;
	

	$msg = wordwrap( $e_body . $e_reply , 70 );

	$headers = "From: $email" . PHP_EOL;
	$headers .= "Reply-To: $email" . PHP_EOL;
	$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
	$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

	if (mail($address, $msg, $headers, $e_content  )) {

		// Email has sent successfully, echo a success page.
	
		echo 'Success';

	} else {

		echo 'ERROR!';

	}

}

?>