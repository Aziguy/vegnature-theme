<?php

$address = get_option('veg_options_email', 'vegnature@vegnature.fr');
if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

$error = false;
$fields = array('name', 'email', 'subject', 'message');

foreach ($fields as $field) {
    if (empty($_POST[$field]) || trim($_POST[$field]) == '') {
        $error = true;
    }
}

if (!$error) {
    $name = stripslashes($_POST['name']);
    $email = trim($_POST['email']);
    $subject = stripslashes($_POST['subject']);
    $message = stripslashes($_POST['message']);
    $e_subject = 'Vous avez été contacté par ' . $name;

    $e_body = "Vous avez été contacté par : $name" . PHP_EOL . PHP_EOL;
    $e_reply = "E-mail: $email" . PHP_EOL . PHP_EOL;
    $e_content = "Message:" . PHP_EOL . $message . PHP_EOL . PHP_EOL;
    $e_content .= "Noms: $name" . PHP_EOL;
    $e_content .= "Objet: $subject" . PHP_EOL;

    $msg = wordwrap($e_body . $e_reply, 70);

    $headers = "From: $email" . PHP_EOL;
    $headers .= "Reply-To: $email" . PHP_EOL;
    $headers .= "MIME-Version: 1.0" . PHP_EOL;
    $headers .= "Content-Type: text/plain; charset=UTF-8" . PHP_EOL;

    if (mail($address, $e_subject, $e_content, $headers)) {
        echo 'Success';
    } else {
        echo 'ERROR!';
    }
}
?>