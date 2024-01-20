<?php

$id_User = $_SESSION['User_id'];
$email = $_SESSION['User_email']; 
$password = $_SESSION['User_password']; 

include 'basedados.h';

$sql = "SELECT * FROM navegador WHERE id = '$id_User' AND email = '$email' AND password = '$password'";
$res = mysqli_query($conn, $sql);

if ($res->num_rows == 0) {
    echo "<script>alert('Erro ao acessar a página!');</script>";
    echo '<script>window.location.href="index.html";</script>';
}

?>
