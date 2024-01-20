<?php

session_start();

include './validarConta.php';


$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

if (!$conn) {
    die('Could not connect: ' . mysqli_error($conn));
}
mysqli_select_db($conn, 'analogo');

$sql = "SELECT * FROM navegador WHERE id like '$id_User' ";

$res = mysqli_query($conn, $sql);

if ($res->num_rows > 0 and isset($id_User)) {
    // Obtém o nome do user da consulta SQL
    $row = $res->fetch_assoc();

    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <link rel="icon" type="image/x-icon" href="logoteste2.png">
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

            .container {
                position: relative;
                max-width: 600px;
                margin: 0 auto;
                margin-top: 5%;
                padding: 20px;
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .container h1 {
                font-size: 24px;
                margin-bottom: 20px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-group label {
                font-weight: bold;
                display: block;
                margin-bottom: 5px;
            }

            .form-group input {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            .form-group textarea {
                width: 100%;
                height: 100px;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                resize: vertical;
            }

            .btn {
                background-color: #4CAF50;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            .btn:hover {
                background-color: #45a049;
            }

            #background {
                position: absolute;
                top: 60px;
                left: 0;
                width: 100%;
                z-index: 0;
            }
        </style>
    </head>

    <?php
    if ($row['tipoUser'] == 0 || $row['tipoUser'] == 1) {
        ?>
        <nav class="navbar">
            <div class="logo">
                <a href="pag_menuuser.php"><img src="images/analogo.png" width="180" height="50" alt="AnaLogo"></a>
            </div>
            <ul>
                <li><a href='pag_menuuser.php'>Página Inicial<span class='sr-only'></span></a></li>
                <li><a href='paginas_Utilizador/pag_criarProjeto.php'>Carregar Marca Gráfica<span class='sr-only'></span></a>
                </li>
                <li><a href='paginas_Utilizador/pag_histProjetos.php'>Histórico de Análise <span class='sr-only'></span></a>
                </li>
                <li><a href='pag_verPerfil.php'>Ver Perfil <span class='sr-only'></span></a></li>
                <li><a href='logout.php'>Desconectar <span class='sr-only'></span></a></li>
            </ul>
        </nav>
        <?php
    } else if ($row['tipoUser'] == 2) {
        ?>
            <nav class="navbar">
                <a href="pag_menuuser.php"><img src="images/analogo.png" width="180" height="50" alt="AnaLogo"></a>
                <ul>
                    <li><a href='pag_menuuser.php'>Página Inicial<span class='sr-only'></span></a></li>
                    <li><a href='paginas_Administrador/pag_listarProjetos.php'>Gerir Projetos <span class='sr-only'></span></a>
                    </li>
                    <li><a href='paginas_Administrador/pag_listarUsers.php'>Gerir Utilizadores <span class='sr-only'></span></a>
                    </li>
                    <li><a href='pag_verPerfil.php'>Ver Perfil <span class='sr-only'></span></a></li>
                    <li><a href='logout.php'>Desconectar <span class='sr-only'></span></a></li>
                </ul>
            </nav>
            <?php
    }
    ?>

    <img id="background" width="100%" src="images/img_8.png">


    <body>
        <div class="container">
            <h1>Editar Perfil</h1>
            <form action="editarPerfil.php" method="post">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo $row['name'] ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $row['email'] ?>">
                </div>
                <div class="form-group">
                    <label for="senha">Palavra-passe:</label>
                    <input type="password" id="psw" name="psw" value="" required>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" value="<?php echo $row['descricao'] ?>"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </body>

    </html>





    <?php
}
?>