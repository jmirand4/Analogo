<?php

session_start();

include './validarConta.php';

$email = $_POST['email'];

validarEmail($email);

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

if (!$conn) {
    die('Could not connect: ' . mysqli_error($conn));
}
mysqli_select_db($conn, 'analogo');

$sql = "SELECT * FROM navegador WHERE id like '$id_User' ";

$res = mysqli_query($conn, $sql);

if ($res->num_rows > 0 and isset($id_User)) {
    // Obtém o nome do usuário da consulta SQL
    $row = $res->fetch_assoc();

    // Restante do seu código

    // Obtenha os novos valores dos campos name, email, password e descricao
    $newName = $_POST['nome'];
    $newPassword = $_POST['psw'];
    $newDescricao = $_POST['descricao'];

    // Atualize os valores na tabela do banco de dados
    $updateQuery = "UPDATE navegador SET name = '$newName', email = '$email', password = '$newPassword', descricao = '$newDescricao' WHERE id = '$id_User'";
    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Dados do perfil atualizados com sucesso!');</script>";
        echo '<script>window.location.href="pag_verPerfil.php";</script>';
    } else {
        echo "Erro ao atualizar os dados do usuário: " . mysqli_error($conn);
    }
}

function validarEmail($email)
{
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass);

    if (!$conn) {
        die('Could not connect: ' . mysqli_error($conn));
    }
    mysqli_select_db($conn, 'analogo');

    $verifyEmailQuery = "SELECT email FROM navegador WHERE email = '$email'";
    $res = mysqli_query($conn, $verifyEmailQuery);

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        if ($row['email'] !== $email) {
            echo "<script>alert('Já existe este email associado a uma conta!');</script>";
            echo '<script>window.location.href="pag_editarPerfil.php";</script>';
        }
    }
}


?>