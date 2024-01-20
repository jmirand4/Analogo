<?php
if (!isset($_SESSION)) {
    session_start();
}

include '../validarConta.php';

$conn = mysqli_init();
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
mysqli_real_connect($conn, $dbhost, $dbuser, $dbpass, 'analogo');

if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM navegador WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    $stmt2 = $conn->prepare("DELETE FROM tb_factos WHERE idNavegador=?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $stmt2->close();
} elseif (isset($_POST['projeto_id'])) {
    $id = $_POST['projeto_id'];
    $stmt = $conn->prepare("DELETE FROM projeto WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    $stmt2 = $conn->prepare("DELETE FROM tb_factos WHERE idProjeto=?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $stmt2->close();
}

echo ("<script LANGUAGE='JavaScript'>window.alert('Eliminado');window.location.href='../pag_menuuser.php';</script>");
?>
