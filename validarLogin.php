<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

if (!$conn) {
    die('Could not connect: ' . mysqli_error($conn));
}

mysqli_select_db($conn, 'analogo');

//verificação na BD com prepared statement e consulta parametrizada
$stmt = mysqli_prepare($conn, "SELECT id FROM navegador WHERE email = ? AND password = ?");
mysqli_stmt_bind_param($stmt, "ss", $email, $password);
mysqli_stmt_execute($stmt);

// Obtém o resultado da consulta preparada
mysqli_stmt_store_result($stmt);

// Verifica se o usuário foi encontrado
if (mysqli_stmt_num_rows($stmt) == 0) {
    echo "<script>alert('O e-mail e/ou palavra-passe que inseriste não está associado a uma conta. Encontra a tua conta e inicia sessão.');</script>";
    echo '<script>window.location.href="index.html";</script>';
} else {
    session_start();
    mysqli_stmt_bind_result($stmt, $user_id); // Lê o resultado "id"
    mysqli_stmt_fetch($stmt); // Armazena o valor de $user_id
    $_SESSION['User_id'] = $user_id; // Adiciona o valor id à variável de sessão "user_id"
    $_SESSION['User_email']=$email; // Adiciona o valor email à variável de sessão "user_email"
    $_SESSION['User_password']=$password; // Adiciona o valor password à variável de sessão "user_password"
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>