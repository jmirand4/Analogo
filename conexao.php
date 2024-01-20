<?php
if (!isset($_SESSION)) {
    session_start();
}

include 'validarConta.php';

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "analogo";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão concluída";

    // Restante do seu código aqui

} catch (PDOException $err) {
    echo "Erro gerado ao conectar com a base de dados: " . $err->getMessage();
}
