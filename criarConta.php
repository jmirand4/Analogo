<?php

$email = $_POST['email'];
$password = $_POST['psw'];
$name = $_POST['name'];

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'analogo';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}

// Verificar se o e-mail já existe no banco de dados
$verificarEmail = "SELECT COUNT(*) AS count FROM navegador WHERE email = ?";
$stmt = mysqli_prepare($conn, $verificarEmail);
mysqli_stmt_bind_param($stmt, 's', $email);
if (!mysqli_stmt_execute($stmt)) {
    die('Could not execute query: ' . mysqli_error($conn));
}

$resultado = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($resultado);

if ($row['count'] > 0) {
    echo "<script>alert('O e-mail já está em uso. Por favor, escolha outro e-mail! Autentique-se!');</script>";
    echo '<script>window.location.href="index.html";</script>';
} else {
    // Inserir o registro no banco de dados
    $inserirRegistro = "INSERT INTO navegador (name, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $inserirRegistro);
    mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $password);
    if (mysqli_stmt_execute($stmt)) {
        echo '<script>window.location.href="index.html";</script>';
    } else {
        die('Could not execute query: ' . mysqli_error($conn));
    }
}

mysqli_close($conn);
?>
