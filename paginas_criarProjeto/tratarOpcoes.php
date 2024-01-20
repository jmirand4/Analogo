<?php
session_start();

include 'validarConta.php';

$opcoes = array(
    'original',
    'pixelizado',
    'blur',
    'favicon',
    'tamanho',
    'cores_negativas',
    'cores_cegas',
    'edit_Cores',
    'cores_usadas',
    'cores_predom',
    'fatiada'
);

$i = 1;
foreach ($opcoes as $opcao) {
    if (isset($_GET[$opcao]) && $_GET[$opcao] == 1) {
        $op = "opcao" . "_" . $i;
        $$op = $_GET[$opcao];

        echo $op . " -> " . $$op;
        echo "<br>";
        addVarProjeto($opcao, $$op);
    }
    $i += 1;
}

function addVarProjeto($opcao, $valorOpcao)
{
    $id_projeto = $_SESSION['id_projeto'];

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass);

    if (!$conn) {
        die('Could not connect: ' . mysqli_error($conn));
    }
    mysqli_select_db($conn, 'analogo');

    $stmt = mysqli_prepare($conn, "UPDATE projeto SET $opcao = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'si', $valorOpcao, $id_projeto);
    mysqli_stmt_execute($stmt);

    mysqli_close($conn);
}

//notificar user que projeto foi criado
//redirecionar para menu user
?>
