<?php
if (!isset($_SESSION)) {
    session_start();
}

include '../validarConta.php';

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$conn = mysqli_init();
mysqli_real_connect($conn, $dbhost, $dbuser, $dbpass, 'analogo');

if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}

$id = $_POST['id'];

if (isset($_POST['projeto'])) {
    $nomeProjeto = $_POST['projeto'];

    if (!empty($nomeProjeto)) {
        $nomeProjeto = mysqli_real_escape_string($conn, $nomeProjeto);

        $stmt = $conn->prepare("UPDATE projeto SET nome=? WHERE id=?");
        $stmt->bind_param("si", $nomeProjeto, $id);
        $stmt->execute();


        $stmt->close();
    }
}

$pixelizado = isset($_POST['pixelizado']) ? 1 : 0;
$blur = isset($_POST['blur']) ? 1 : 0;
$favicon = isset($_POST['favicon']) ? 1 : 0;
$tamanho = isset($_POST['tamanho']) ? 1 : 0;
$cores_negativas = isset($_POST['cores_negativas']) ? 1 : 0;
$cores_cegas = isset($_POST['cores_cegas']) ? 1 : 0;
$edit_cores = isset($_POST['edit_cores']) ? 1 : 0;
$cores_usadas = isset($_POST['cores_usadas']) ? 1 : 0;
$cores_predom = isset($_POST['cores_predom']) ? 1 : 0;
$fatiada = isset($_POST['fatiada']) ? 1 : 0;

if ($pixelizado == 0 && $blur == 0 && $favicon == 0 && $tamanho == 0 && $cores_negativas == 0 && $cores_cegas == 0 && $edit_cores == 0 && $cores_usadas == 0 && $cores_predom == 0 && $fatiada == 0) {
    // Todas as variáveis são iguais a zero, não faz nada
} else {
    $stmt = $conn->prepare("UPDATE projeto SET pixelizado=?, blur=?, favicon=?, tamanho=?, cores_negativas=?, cores_cegas=?, edit_cores=?, cores_usadas=?, cores_predom=?, fatiada=? WHERE id=?");
    $stmt->bind_param("iiiiiiiiiii", $pixelizado, $blur, $favicon, $tamanho, $cores_negativas, $cores_cegas, $edit_cores, $cores_usadas, $cores_predom, $fatiada, $id);
    $stmt->execute();


    $stmt->close();

    $stmt = $conn->prepare("SELECT logocarregada.Logo FROM logocarregada INNER JOIN tb_factos ON logocarregada.id = tb_factos.idLogo INNER JOIN projeto ON tb_factos.idProjeto = projeto.id WHERE projeto.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->bind_result($logoCarregada);
    $stmt->fetch();

    $stmt->close();

    if (isset($logoCarregada)) {
        $imagemRecortada = $logoCarregada;
    }

    include 'editarProjeto.php';

    if (isset($todasFuncoesConcluidas) && $todasFuncoesConcluidas) {
        // Todas as funções foram concluídas

    } else {
        // Funções a executar
    }
}

echo ("<script LANGUAGE='JavaScript'>window.alert('Editado');window.location.href='../pag_menuuser.php';</script>");
?>
