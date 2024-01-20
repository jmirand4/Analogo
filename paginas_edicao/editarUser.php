<?php
if (!isset($_SESSION)) {
    session_start();
}

include 'validarConta.php';

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$conn = mysqli_init();
mysqli_real_connect($conn, $dbhost, $dbuser, $dbpass, 'analogo');

if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}

$id = $_POST['id'];

if (isset($_POST['username']) && $_POST['username'] !== '') {
    $username = $_POST['username'];
    $stmt = $conn->prepare("UPDATE navegador SET name=? WHERE id=?");
    $stmt->bind_param("si", $username, $id);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['email']) && $_POST['email'] !== '') {
    $email = $_POST['email'];
    $stmt = $conn->prepare("UPDATE navegador SET email=? WHERE id=?");
    $stmt->bind_param("si", $email, $id);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['password']) && $_POST['password'] !== '') {
    $password = $_POST['password'];
    $stmt = $conn->prepare("UPDATE navegador SET password=? WHERE id=?");
    $stmt->bind_param("si", $password, $id);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['mudar_tipoUser']) && $_POST['mudar_tipoUser'] !== '') {
    $mudar_tipoUser = $_POST['mudar_tipoUser'];
    $stmt = $conn->prepare("UPDATE navegador SET tipoUser=? WHERE id=?");
    $stmt->bind_param("ii", $mudar_tipoUser, $id);
    $stmt->execute();
    $stmt->close();
}

echo ("<script LANGUAGE='JavaScript'>window.alert('Editado');window.location.href='../pag_menuuser.php';</script>");
?>