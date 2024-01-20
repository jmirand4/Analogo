<?php
if (!isset($_SESSION)) {
    session_start();
}

include '../validarConta.php';
$user_id = $_SESSION['User_id'];

$verificarTipoUser = "SELECT tipoUser FROM navegador WHERE id = $user_id";

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

    <html>

    <head>
        <link rel="icon" type="image/x-icon" href="../logoteste2.png">
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>AnaLogo</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>

    <style>
        * {
            text-decoration: none;
        }

        body {
            background-color: whitesmoke;
            font-family: calibri;
            margin: 0;
            padding: 0;
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

        .edit_users {
            display: flex;
            justify-content: center;
            width: 100%;
            overflow-x: hidden;
        }

        table {
            border: 2px solid black;
            text-align: center;
        }

        th,
        td {
            padding: 10px;
        }

        .eliminar-column,
        .editar-column {
            max-width: 80px;
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

        <?php
        include '../navbar/navbarAdministrador.html';
        

        

        echo '<div class="edit_users">';
        echo "<table border='2'> 
        <tr>
            <th style='width: 20%;'>Id</th>
            <th style='width: 20%;'>Nome</th>
            <th style='width: 20%;'>Palavra-passe</th>
            <th style='width: 20%;'>Email</th>
            <th style='width: 20%;'>Número de Projetos</th>
            <th class='eliminar-column'>Eliminar</th>
            <th class='editar-column'>Editar</th>
        </tr>";

        $sql = "SELECT navegador.id AS id, navegador.name AS name, navegador.password AS password, navegador.email AS email, COUNT(tb_factos.idProjeto) AS nProjeto FROM navegador LEFT JOIN tb_factos ON navegador.id = tb_factos.idnavegador WHERE navegador.tipoUser != 2 GROUP BY navegador.id";
        $retval = mysqli_query($conn, $sql);

        if (!$retval) {
            die('Could not get data: ' . mysqli_error($conn));
        }

        while ($row = mysqli_fetch_array($retval)) {
            echo "<tr>";
            echo "<td><p>" . $row['id'] . "</p></td>";
            echo "<td><p>" . $row['name'] . "</p></td>";
            echo "<td><p>" . $row['password'] . "</p></td>";
            echo "<td><p>" . $row['email'] . "</p></td>";
            echo "<td><p>" . ($row['nProjeto'] != 0 ? $row['nProjeto'] : "0") . "</p></td>";
            echo "<td><a href='../paginas_edicao/eliminar.php?id=" . $row['id'] . "'><img width='100%' src='../images/eliminar.png' alt='Eliminar'></a></td>";
            echo "<td><a href='pag_editarUtilizadores.php?id=" . $row['id'] . "'><img width='150%' src='../images/editar.png' alt='Editar'></a></td>";
            echo "</tr>";
        }

        echo '</table>';
        echo '</div>';
        ?>

    </body>

    </html>

    <?php
}
?>