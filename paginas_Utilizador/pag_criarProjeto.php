<?php
session_start();
include '../validarConta.php';
?>


<!DOCTYPE html>
<html>

<head>
  <link rel="icon" type="image/x-icon" href="../logoteste2.png">
  <meta charset="UTF-8" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Criar Projeto</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <style>
    h2 {
      text-align: center;
    }

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


    .cor {
      background-color: grey;
      opacity: 0.8;
    }

    input[type=submit] {
      width: 170px;
      max-width: 100%;
      color: #fff;
      padding: 10px;
      background: crimson;
      border-radius: 10px;
      border: none;
      cursor: pointer;
    }

    input[type=submit]:hover {
      background: darkred;
    }

    label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }

    input[type=text] {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    #logo-Center {
      display: block;
      margin: 0 auto;
    }

    .container {
      position: relative;
      z-index: 2;
    }

    #background {
      position: absolute;
      top: 60px;
      left: 0;
      width: 100%;
      z-index: 1;
    }

    .center {
      position: absolute;
      width: 40%;
      top: 380px;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 20px;
      text-align: center;
    }

    h2 {
      font-weight: bold;
      color: whitesmoke
    }
  </style>
</head>

<body>

<?php include '../navbar/navbarUtilizador.html'; ?>


  <img id="background" width="100%" src="../images/img_6.png">
  <div class="container">

    <div class="center">
      <form action="../paginas_criarProjeto/criarProjeto.php" method="POST">
        <label for="nome">
          <h2>Nome do Projeto</h2>
        </label>
        <input type="text" placeholder="Coloque Nome do Projeto" name="projeto" required>
        <br><br>
        <input type="submit" value="Enviar">
      </form>
    </div>
  </div>


</body>

</html>