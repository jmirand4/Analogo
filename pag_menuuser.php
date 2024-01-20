<?php
session_start();

include 'validarConta.php';

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

      #background {
        position: absolute;
        top: 60px;
        left: 0;
        width: 100%;
        z-index: 1;
      }

      .container {
        position: absolute;
        z-index: 2;
        padding: 20px;
        top: 50px;

      }

      h1 {
        font-family: courier, arial, helvetica
      }
    </style>
  </head>

  <body>




    <?php
    if ($row['tipoUser'] == 0 || $row['tipoUser'] == 1) {
      ?>
      <nav class="navbar">
        <div class="logo">
          <a href="#"><img src="images/analogo.png" width="180" height="50" alt="AnaLogo"></a>
        </div>
        <ul>
          <li><a href='pag_menuuser.php'>Menu<span class='sr-only'></span></a></li>
          <li><a href='paginas_Utilizador/pag_criarProjeto.php'>Carregar Marca Gráfica<span class='sr-only'></span></a></li>
          <li><a href='paginas_Utilizador/pag_histProjetos.php'>Histórico de Análise <span class='sr-only'></span></a></li>
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
            <li><a href='pag_menuuser.php'>Menu<span class='sr-only'></span></a></li>
            <li><a href='paginas_Administrador/pag_listarProjetos.php'>Gerir Projetos <span class='sr-only'></span></a></li>
            <li><a href='paginas_Administrador/pag_listarUsers.php'>Gerir Utilizadores <span class='sr-only'></span></a></li>
            <li><a href='pag_verPerfil.php'>Ver Perfil <span class='sr-only'></span></a></li>
            <li><a href='logout.php'>Desconectar <span class='sr-only'></span></a></li>
          </ul>
        </nav>
        <?php
    }
    ?>


    </ul>
    </nav>

    <?php
    if ($row['tipoUser'] == 0 || $row['tipoUser'] == 1) {
      echo '<img id="background" width="100%" src="images/img_4.jpeg">';
    } else if ($row['tipoUser'] == 2) {
      echo '<img id="background" width="100%" src="images/img_5.png">';
    }
    ?>
    <div class="container">


      <?php
      if ($row['tipoUser'] == 0 || $row['tipoUser'] == 1) {
        echo "<h1>Bem-vindo Utilizador:  " . $row['name'] . "</h1>";
      } else if ($row['tipoUser'] == 2) {
        echo "<h1 style='color: white;' >Bem-vindo Administrador " . $row['name'] . "</h1>";

      }
      ?>
    </div>

  </body>

  </html>

  <?php
} else {
  header("Location: index.html");
}
?>