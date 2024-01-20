<?php
session_start();

$id_User = $_SESSION['User_id'];

include '../validarConta.php';

$verificarTipoUser = "SELECT tipoUser from navegador where id = $id_User";

$retTipoUser = mysqli_query($conn, $verificarTipoUser);
if (!$retTipoUser) {
    die('Could not get data: ' . mysqli_error($conn)); // se não funcionar dá erro
}

$row = mysqli_fetch_assoc($retTipoUser);
$tipoUser = $row['tipoUser'];
?>

<html>

<head>
    <link rel="icon" type="image/x-icon" href="../logoteste2.png">
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AnaLogo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../tabela.css">
</head>

<style>
    * {
        text-decoration: none;
    }

    .navbar {
        background: crimson;
        font-family: cursive;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        position: relative;
        z-index: 10;
    }

    .navbar ul {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .navbar ul li {
        margin-right: 25px;
    }

    .navbar ul li a {
        color: white;
        font-size: 18px;
        font-weight: bold;
    }

    body {
        background-color: whitesmoke;
        font-family: calibri;
        margin: 0;
        padding: 0;
    }

    @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700');

    $base-spacing-unit: 24px;
    $half-spacing-unit: $base-spacing-unit / 2;

    $color-alpha: #1772FF;
    $color-form-highlight: #EEEEEE;

    *,
    *:before,
    *:after {
        box-sizing: border-box;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        margin: 0;
    }

    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 50px;
        /* Adicione uma margem superior de 200px */
    }

    .filter__link {
        color: white;
        text-decoration: none;
        position: relative;
        display: inline-block;
        padding-left: $base-spacing-unit;
        padding-right: $base-spacing-unit;

        &::after {
            content: '';
            position: absolute;
            right: -($half-spacing-unit * 1.5);
            color: white;
            font-size: $half-spacing-unit;
            top: 50%;
            transform: translateY(-50%);
        }

        &.desc::after {
            content: '(desc)';
        }

        &.asc::after {
            content: '(asc)';
        }
    }

    #background {
        position: absolute;
        top: 70px;
        width: 100%;
        height: 100%;
        z-index: -1;
        opacity: 0.5;
    }

    .table-container {
        background-color: white;
        margin-top: 10px;
        position: relative;
        z-index: 2;
    }

    .project-link {
        text-decoration: none;
        color: #333;
    }

    .project-name {
        font-weight: bold;
        font-size: 16px;
    }

    .sr-only {
        /* Estilos para esconder o texto da tela */
        position: absolute;
        left: -9999px;
    }

    .table {
        width: 60%;
    }
</style>

<body>

<?php include '../navbar/navbarUtilizador.html'; ?>

    <img id="background" width="100%" src="../images/img_7.png">
    <div class="container">
        <?php
        
        
        // Consulta SQL para obter os dados
        $sql = "SELECT projeto.id as id, projeto.nome as nome FROM projeto INNER JOIN tb_factos ON projeto.id = tb_factos.idProjeto INNER JOIN navegador ON tb_factos.idNavegador = navegador.id WHERE navegador.id = '" . $_SESSION['User_id'] . "';";
        $retval = mysqli_query($conn, $sql);
        if (!$retval) {
            die('Could not get data: ' . mysqli_error($conn));
        }
        // Verificar se existem resultados
        if (mysqli_num_rows($retval) > 0) {
            echo '<div class="container">
                <div class="table">
                    <div class="table-header">
                        <div class="header__item"><a id="name" class="filter__link" >Nome</a></div>';
            if ($tipoUser == 1) {
                echo '<div class="header__item"><a id="wins" class="filter__link filter__link--number" >Gerar Relatório</a></div>';
            }
            echo '</div>';
            // Exibir os resultados na tabela
            while ($row = mysqli_fetch_array($retval)) {
                echo '<div class="table-row">';
                echo '<div class="table-data">';


                echo '<div class="table-data">';
                echo '<a class="project-link" href="tratarLogos.php?projeto=' . $row['id'] . '">';
                echo '<span class="project-name">' . $row['nome'] . '</span>';
                echo '<span class="sr-only">(link)</span>';
                echo '</a>';
                echo '</div>';

                echo '</div>';
                if ($tipoUser == 1) {
                    echo '<div class="table-data">';
                    echo '<a href="gerar_pdf.php?projeto=' . $row['id'] . '"><img width="10%" src="../images/img_pdf.png" alt="Gerar PDF"></a>';
                    echo '</div>';
                }
                echo '</div>';
            }
            echo '</div>';
        } else {
            // Caso não haja resultados
            echo '<h2>Não há projetos de teste de marcas gráficas criados.</h2>';
        }
        mysqli_close($conn);
        ?>
    </div>

</body>

</html>