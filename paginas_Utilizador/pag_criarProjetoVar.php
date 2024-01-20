<?php
session_start();

include '../validarConta.php';

$id_User = $_SESSION['User_id'];

if (!isset($_GET['projeto'])) {
  echo "<script>alert('Erro ao acessar a página!');</script>";
  echo '<script>window.location.href="logout.php";</script>';
  exit;
}

$id_Projeto = $_GET['projeto'];

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'analogo';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
  die('Could not connect: ' . mysqli_connect_error());
}

$sql = "SELECT * FROM navegador WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $id_User);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);


if ($res->num_rows > 0 && isset($id_User)) {
  // Obtém o nome do usuário da consulta SQL
  $row = $res->fetch_assoc();
  ?>

  <html>

  <head>
    <link rel="icon" type="image/x-icon" href="../logoteste2.png">
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Criar Projeto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  </head>

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

    .center {

      margin: auto;
      width: 80%;
      padding: 10px;
      top: 20%;
      left: 50%;
      -ms-transform: translate(30%, 30%);
      transform: translate(0%, 30%);
    }

    .cor {
      background-color: grey;
      opacity: 0.8;
    }

    input[type=submit] {
      padding: 5px 15px;
      background: #ccc;
      cursor: pointer;
      border-radius: 5px;
    }

    .drop-container {
      position: relative;
      display: flex;
      gap: 10px;
      flex-direction: column;
      align-items: center;
      height: 200px;
      width: 400px;
      padding: 10px;
      border-radius: 40px;
      border: 2px dashed #555;
      color: #444;
      cursor: pointer;
      transition: background .2s ease-in-out, border .2s ease-in-out;
    }

    .drop-container:hover {
      background: #eee;
      border-color: #111;
    }

    .drop-container:hover .drop-title {
      color: #222;
    }

    .drop-title {
      color: #444;
      font-size: 20px;
      font-weight: bold;
      text-align: center;
      transition: color .2s ease-in-out;
    }

    input[type=file] {
      width: 170px;
      max-width: 100%;
      color: #444;
      padding: 5px;
      background: #fff;
      border-radius: 10px;
      border: 1px solid #555;
    }

    input[type=file]::file-selector-button {
      margin-right: 20px;
      border: none;
      background: #084cdf;
      padding: 10px 20px;
      border-radius: 10px;
      color: #fff;
      cursor: pointer;
      transition: background .2s ease-in-out;
    }

    input[type=file]::file-selector-button:hover {
      background: #0d45a5;
    }

    label {
      margin: 20px 60px;
    }

    #logo-Menu {
      position: absolute;
      right: 80px;
      top: 16px;
    }

    #logo-Center {
      display: block;
      margin: 0 auto;
    }

    .form-container {
      position: relative;
      z-index: 9999;
      top: 180px;
    }

    .form-container input[type=email],
    .form-container input[type=password],
    .form-container input[type=text] {
      width: 100%;
      padding: 15px;
      margin: 5px 0 22px 0;
      border: none;
      background: #f1f1f1;

    }

    .form-container input[type=email]:focus,
    .form-container input[type=password]:focus,
    .form-container input[type=text]:focus {
      background-color: #ddd;
      outline: none;
    }

    .form-container .btn {
      background-color: #04AA6D;
      color: white;
      padding: 16px 20px;
      border: none;
      cursor: pointer;
      width: 40%;
      margin-bottom: 10px;
      opacity: 0.8;

    }

    .form-container .btn:hover,
    .open-button:hover {
      opacity: 1;
    }

    .open-button1 {
      background-color: #555;
      color: white;
      padding: 16px 20px;
      border: none;
      cursor: pointer;
      opacity: 0.8;
      position: absolute;
      right: 598px;
      width: 250px;
      top: 202px;
      margin: 0 auto;
    }

    .form-popup {
      display: none;
    }

    input[type=submit] {
      padding: 5px 15px;
      background: #ccc;
      cursor: pointer;
      border-radius: 5px;
    }

    .drop-container {
      position: relative;
      display: flex;
      gap: 10px;
      flex-direction: column;
      align-items: center;
      height: 200px;
      width: 400px;
      padding: 10px;
      border-radius: 40px;
      border: 2px dashed #555;
      color: #444;
      cursor: pointer;
      transition: background .2s ease-in-out, border .2s ease-in-out;
    }

    .drop-container:hover {
      background: #eee;
      border-color: #111;
    }

    .drop-container:hover .drop-title {
      color: #222;
    }

    .drop-title {
      color: #444;
      font-size: 20px;
      font-weight: bold;
      text-align: center;
      transition: color .2s ease-in-out;
    }

    input[type=file] {
      width: 170px;
      max-width: 100%;
      color: #444;
      padding: 5px;
      background: #fff;
      border-radius: 10px;
      border: 1px solid #555;
    }

    input[type=file]::file-selector-button {
      margin-right: 20px;
      border: none;
      background: #084cdf;
      padding: 10px 20px;
      border-radius: 10px;
      color: #fff;
      cursor: pointer;
      transition: background .2s ease-in-out;
    }

    input[type=file]::file-selector-button:hover {
      background: #0d45a5;
    }

    label {
      margin: 20px 60px;
    }

    /* Hide the default checkbox */
    .container input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;
    }

    .container {
      display: block;
      position: relative;
      cursor: pointer;
      font-size: 20px;
      user-select: none;
    }

    /* Create a custom checkbox */
    .checkmark {
      position: relative;
      top: 0;
      left: 0;
      height: 1.3em;
      width: 1.3em;
      background: #606062;
      border-radius: 5px;
      box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.30), 0px 1px 1px rgba(0, 5);
    }

    /* When the checkbox is checked, add a blue background */
    .container input:checked~.checkmark {
      background-image: linear-gradient(#b9e9b3, #a8e4a0)
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }

    /* Show the checkmark when checked */
    .container input:checked~.checkmark:after {
      display: block;
    }

    /* Style the checkmark/indicator */
    .container .checkmark:after {
      left: 0.45em;
      top: 0.25em;
      width: 0.25em;
      height: 0.5em;
      border: solid white;
      border-width: 0 0.15em 0.15em 0;
      transform: rotate(45deg);
    }

    input[type="checkbox"] {
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      border: 2px solid #00BFFF;
      margin-right: 8px;
      outline: none;
    }

    input[type="checkbox"]:checked::before {
      content: "";
      display: block;
      width: 10px;
      height: 10px;
      margin: 3px;
      background-color: #00BFFF;
      border-radius: 50%;
    }

    .btn {
      align-items: center;
      background-color: #FFFFFF;
      border: 1px solid rgba(0, 0, 0, 0.1);
      border-radius: .25rem;
      box-shadow: rgba(0, 0, 0, 0.02) 0 1px 3px 0;
      box-sizing: border-box;
      color: rgba(0, 0, 0, 0.85);
      cursor: pointer;
      display: inline-flex;
      font-family: system-ui, -apple-system, system-ui, "Helvetica Neue", Helvetica, Arial, sans-serif;
      font-size: 16px;
      font-weight: 600;
      justify-content: center;
      line-height: 1.25;
      min-height: 3rem;
      padding: calc(.875rem - 1px) calc(1.5rem - 1px);
      text-decoration: none;
      transition: all 250ms;
      user-select: none;
      -webkit-user-select: none;
      touch-action: manipulation;
      vertical-align: baseline;
      width: auto;
      box-shadow: 5px 4px 6px 4px #888888;
    }

    .btn:hover,
    .btn:focus {
      border-color: rgba(0, 0, 0, 0.15);
      box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
      color: rgba(0, 0, 0, 0.65);
    }

    .btn:hover {
      transform: translateY(-1px);
    }

    .btn:active {
      background-color: #F0F0F1;
      border-color: rgba(0, 0, 0, 0.15);
      box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px;
      color: rgba(0, 0, 0, 0.65);
      transform: translateY(0);
    }

    .open-button {
      align-items: center;
      background-color: #FFFFFF;
      border: 1px solid rgba(0, 0, 0, 0.1);
      border-radius: .25rem;
      box-shadow: rgba(0, 0, 0, 0.02) 0 1px 3px 0;
      box-sizing: border-box;
      color: rgba(0, 0, 0, 0.85);
      cursor: pointer;
      display: inline-flex;
      font-family: system-ui, -apple-system, system-ui, "Helvetica Neue", Helvetica, Arial, sans-serif;
      font-size: 16px;
      font-weight: 600;
      justify-content: center;
      line-height: 1.25;
      min-height: 3rem;
      padding: calc(.875rem - 1px) calc(1.5rem - 1px);
      text-decoration: none;
      transition: all 250ms;
      user-select: none;
      -webkit-user-select: none;
      touch-action: manipulation;
      vertical-align: baseline;
      width: auto;
      box-shadow: 5px 4px 6px 4px #888888;
    }

    .open-button:hover,
    .open-button:focus {
      border-color: rgba(0, 0, 0, 0.15);
      box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
      color: rgba(0, 0, 0, 0.65);
    }

    .open-button:hover {
      transform: translateY(-1px);
    }

    .open-button:active {
      background-color: #F0F0F1;
      border-color: rgba(0, 0, 0, 0.15);
      box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px;
      color: rgba(0, 0, 0, 0.65);
      transform: translateY(0);
    }

    .options {
      position: relative;
      top: -10;
    }

    .options table {
      width: 50%;
      border-collapse: collapse;
      
    }

    .options td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ccc;
      text-align: left;
     
    }


    .options input[type="checkbox"] {
      margin-right: -20px;
      margin-left: 100px;
    }

    .options label {
      font-size: 14px;
      color: #333;
    }

    .options td:first-child {
      width: 50%;
    }

    .options td:nth-child(2) {
      width: 50%;
    }

    .options label.label-inline {
      display: inline-block;
      margin-right: 5px;
    }

    #background {
      position: absolute;
      top: 60px;
      left: 0;
      width: 100%;
      z-index: 1;
    }
  </style>

  <body>
    <?php
    include '../navbar/navbarUtilizador.html';





    echo '<center>';

    echo '<img id="background" width="100%" src="../images/img_6.png">';

    echo '<form id="hidden_form" action="../paginas_criarProjeto/criarProjetoVar.php" class="form-container" method="POST">';
    echo '<input type="hidden" name="projeto" value="' . $id_Projeto . '">';
    ?>


    <br>



    <div class="options" id="display_options">
      <table>
        <tr>
          <td>
            <input type="checkbox" name="pixelizado" id="chk_pixelizado">

            <label for="chk_pixelizado">Pixelizado</label>
          </td>
          <td>
            <input type="checkbox" name="blur" id="chk_blur">

            <label for="chk_blur">Blur</label>
          </td>
        </tr>
        <tr>
          <td>
            <input type="checkbox" name="favicon" id="chk_favicon">

            <label for="chk_favicon">FavIcon</label>
          </td>
          <td>
            <input type="checkbox" name="tamanho" id="chk_tamanho">

            <label for="chk_tamanho">Tamanho</label>
          </td>
        </tr>
        <tr>
          <td>
            <input type="checkbox" name="cores_negativas" id="chk_cores_negativas">

            <label for="chk_cores_negativas">Inversão de Cores</label>
          </td>
          <td>
            <input type="checkbox" name="cores_cegas" id="chk_cores_cegas">

            <label for="chk_cores_cegas">Daltonismo</label>
          </td>
        </tr>
        <tr>
          <td>
            <input type="checkbox" name="edit_Cores" id="chk_edit_Cores">

            <label for="chk_edit_Cores">Edição de Cores</label>
          </td>
          <td>
            <input type="checkbox" name="cores_usadas" id="chk_cores_usadas">

            <label for="chk_cores_usadas">Cores Usadas</label>
          </td>
        </tr>
        <tr>
          <td>
            <input type="checkbox" name="cores_predom" id="chk_cores_predom">

            <label for="chk_cores_predom">Cores Predominantes</label>
          </td>
          <td>
            <input type="checkbox" name="fatiada" id="chk_fatiada">

            <label for="chk_fatiada">Recortada</label>
          </td>
        </tr>
      </table>
    </div>


    <br><br>
    <button id="button_addLogo" class="open-button" onclick="validateOptionsAndOpenForm()">Enviar</button>

    <div class="form-popup" id="myFormLogo">
      <label for="images" class="drop-container">
        <span class="drop-title">Carregue o Logótipo para Enviar</span>
        <input type="file" name="logo" accept="image/*" required>
      </label>
      <button type="submit" class="btn" onclick="return validateForm()">Enviar</button>
    </div>

    <script>
      function validateOptionsAndOpenForm() {
        var checkboxes = document.querySelectorAll('#display_options input[type="checkbox"]');
        var optionSelected = false;
        checkboxes.forEach(function (checkbox) {
          if (checkbox.checked) {
            optionSelected = true;
          }
        });
        if (!optionSelected) {
          alert('Selecione pelo menos uma opção!');
        } else {
          hideOptions();
          openFormPopup();
        }
      }

      function hideOptions() {
        document.getElementById('display_options').style.display = 'none';
        document.getElementById('button_addLogo').style.display = 'none';
      }

      function openFormPopup() {
        document.getElementById('myFormLogo').style.display = 'block';
      }
    </script>
    </center>

  </body>

  </html>
  <?php
} else {
  echo "<script>alert('Erro ao acessar a página!');</script>";
  echo '<script>window.location.href="logout.php";</script>';
}
mysqli_close($conn);
?>