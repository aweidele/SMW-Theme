<?php
$to = $_POST['to'];
$subject = 'SMW: New Memory from '.$_POST['full_name'];
$headers = 'From: '.$_POST['full_name'].'<'.$_POST['email'].'>' . "\r\n" .
    'Reply-To: '.$_POST['email']. "\r\n" .
    'X-Mailer: PHP/' . phpversion();
$message = $_POST['message'];
mail($to, $subject, $message, $headers);
header("Location: ".$_POST['redirect']."?submitted=true#".$_POST['section']);
?>
<pre><?php print_r($_POST); ?>
<?php echo $headers; ?>
</pre>