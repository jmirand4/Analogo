<?php
if (!isset($_SESSION)) {
    session_start();
}

include '../validarConta.php';

$user_id = $_SESSION['User_id'];

$verificarTipoUser = "SELECT tipoUser from navegador where id = $user_id";

$retTipoUser = mysqli_query($conn, $verificarTipoUser);
if (!$retTipoUser) {
    die('Could not get data: ' . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($retTipoUser);
$tipoUser = $row['tipoUser'];

if ($tipoUser != 2) {
    echo "<script>alert('Sem Permissões para aceder a página ou Página não Existe!');</script>";
    echo '<script>window.location.href="../logout.php";</script>';
} else {
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <link rel="icon" type="image/x-icon" href="../logoteste2.png">
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>AnaLogo</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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

            .edit_projetos {
                display: flex;
                justify-content: center;
            }

            table {
                border: 2px solid black;
                width: 100%;
                text-align: center;
            }

            th,
            td {
                padding: 10px;
            }

            .eliminar-column,
            .editar-column {
                max-width: 50px;
                word-wrap: break-word;
            }

            p {
                font-family: Arial, sans-serif;
                font-size: 16px;
                line-height: 1.5;
                color: #333;
                background-color: #f5f5f5;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
        </style>
    </head>

    <body>
        <?php include '../navbar/navbarAdministrador.html'; ?>

        <div class="edit_projetos">
            <?php
            mysqli_select_db($conn, 'analogo');

            echo "<table border='2'> 
            <tr>
                <th style='width: 20%;'>Id</th> 
                <th style='width: 20%;'>Nome do Projeto</th>
                <th style='width: 20%;'>Marca Gráfica</th> 
                <th style='width: 20%;'>Criador do Projeto</th> 
                <th class='eliminar-column'>Eliminar</th> 
                <th class='editar-column'>Editar</th>
            </tr>";

            $sql2 = "SELECT p.id as projeto_id, p.nome as projeto_nome, l.Logo as logo, n.name as nome_navegador, n.id as id_navegador FROM projeto p INNER JOIN tb_factos tb ON p.id = tb.idProjeto INNER JOIN navegador n ON tb.idNavegador = n.id INNER JOIN logocarregada l ON tb.idLogo = l.id";

            $retval2 = mysqli_query($conn, $sql2);

            if (!$retval2) {
                die('Could not get data: ' . mysqli_error($conn));
            }

            while ($row = mysqli_fetch_array($retval2)) {
                echo "<tr>";
                echo "<td><p>" . $row['projeto_id'] . "</p></td>";
                echo "<td><p>" . $row['projeto_nome'] . "</p></td>";
                echo "<td><p><img width='40%' src='../imagens/" . $row['logo'] . "'></p></td>";
                echo "<td><p>" . $row['nome_navegador'] . "<br>(" . $row['id_navegador'] . ")</p></td>";
                echo "<td class='eliminar-column'>
                    <form action='../paginas_edicao/eliminar.php' method='POST'>
                        <input type='hidden' name='projeto_id' value='" . $row['projeto_id'] . "'>
                        <button type='submit' style='border: none; background: none; padding: 0;'><img width='100%' src='../images/eliminar.png'></button>
                    </form>
                </td>";
                echo "<td class='editar-column'>
                    <form action='pag_editarProjetos.php' method='POST'>
                        <input type='hidden' name='projeto_id' value='" . $row['projeto_id'] . "'>
                        <button type='submit' style='border: none; background: none; padding: 0;'><img width='75%' src='../images/editar.png'></button>
                    </form>
                </td>";
                echo "</tr>";
            }

            echo '</table>';
            ?>
        </div>

    </body>

    </html>

    <?php
}
?>