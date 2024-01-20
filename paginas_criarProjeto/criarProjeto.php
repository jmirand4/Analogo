<?php
session_start();

include '../validarConta.php';

if (!isset($_POST['projeto'])) {
    echo "<script>alert('Erro ao aceder à página!');</script>";
    echo '<script>window.location.href="logout.php";</script>';
    exit;
}

$projeto = $_POST['projeto'];

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'analogo';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (! $conn ){
    die('Could not connect: ' . mysqli_connect_error());
}

$sql = "INSERT INTO projeto (nome) VALUES (?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 's', $projeto);

if (mysqli_stmt_execute($stmt)) {
    $projeto_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    echo "<script> window.location.href = '../paginas_Utilizador/pag_criarProjetoVar.php?projeto=' + " . json_encode($projeto_id) . ";</script>";
    exit;
} else {
    die('Could not execute query: ' . mysqli_error($conn));
}

?>