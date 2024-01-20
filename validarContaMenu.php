<?php






$email = urldecode($_POST['email']);

$password =  urldecode($_POST['psw']);


include 'validarLogin.php';


echo '<script>window.location.href="pag_menuuser.php";</script>';


?>
