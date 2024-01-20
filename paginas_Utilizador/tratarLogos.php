<?php

session_start();

include '../validarConta.php';

$user_id = $_SESSION['User_id'];

$projeto = $_GET['projeto'];


$opcoesEscolhidas[] = array();


// Consulta parametrizada para evitar SQL Injection
$sql = "SELECT * FROM projeto 
        INNER JOIN tb_factos ON projeto.id = tb_factos.idProjeto 
        INNER JOIN navegador ON tb_factos.idNavegador = navegador.id 
        WHERE navegador.id = ? AND projeto.id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $projeto);
mysqli_stmt_execute($stmt);

$retval = mysqli_stmt_get_result($stmt);


array_push($opcoesEscolhidas, 'fim');

while ($row = mysqli_fetch_array($retval)) { // vai buscar ha base de dados os dados nela guardada e poem os na tabela

  if ($row['original'] == 1)
    array_push($opcoesEscolhidas, 'original');

  if ($row['pixelizado'] == 1)
    array_push($opcoesEscolhidas, 'pixelizado');

  if ($row['blur'] == 1)
    array_push($opcoesEscolhidas, 'blur');

  if ($row['favicon'] == 1)
    array_push($opcoesEscolhidas, 'favicon');

  if ($row['tamanho'] == 1)
    array_push($opcoesEscolhidas, 'tamanho');

  if ($row['cores_negativas'] == 1)
    array_push($opcoesEscolhidas, 'cores_negativas');

  if ($row['cores_cegas'] == 1)
    array_push($opcoesEscolhidas, 'cores_cegas');

  if ($row['edit_cores'] == 1)
    array_push($opcoesEscolhidas, 'edit_cores');

  if ($row['cores_usadas'] == 1)
    array_push($opcoesEscolhidas, 'cores_usadas');

  if ($row['cores_predom'] == 1)
    array_push($opcoesEscolhidas, 'cores_predom');

  if ($row['fatiada'] == 1)
    array_push($opcoesEscolhidas, 'fatiada');
}



// Consulta parametrizada para evitar SQL Injection
$getLogo = "SELECT * FROM logocarregada 
          INNER JOIN tb_factos ON logocarregada.id = tb_factos.idLogo 
          INNER JOIN projeto ON tb_factos.idProjeto = projeto.id 
          INNER JOIN navegador ON navegador.id = tb_factos.idNavegador 
          WHERE navegador.id = ? AND projeto.id= ?";

$stmt = mysqli_prepare($conn, $getLogo);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $projeto);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_array($result)) { // fetch data from the result
  $logo = $row['Logo'];
}

$logoRedimensionar = __DIR__ . '/../imagens/';

include '../paginas_criarProjeto/detectColours.php';

include '../paginas_criarProjeto/redimensionarImagem.php';

?>



<html>

<head>
  <link rel="icon" type="image/x-icon" href="../logoteste2.png">
  <meta charset="UTF-8" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>AnaLogo</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="../tabela_cores_cegas.css">
</head>
<style>
  /* Estilos gerais dos modais */
  .modal {
    display: none;
    position: fixed;
    z-index: 0;
    left: 0;
    top: 10%;
    /* aumentando o valor de top */
    width: 100%;
    max-height: 90%;
    /* definindo um limite máximo para a altura */
    overflow: auto;
    transition: top 0.5s ease;

  }

  #modal_original {
    display: block;
  }


  #modal_pixelizado {
    animation-name: sliceLeft;
    animation-duration: 1s;
  }

  #modal_blur {
    animation-name: sliceLeft;
    animation-duration: 1s;
  }

  #modal_favicon {
    animation-name: sliceLeft;
    animation-duration: 1s;
  }

  #modal_tamanho {
    animation-name: sliceLeft;
    animation-duration: 1s;

  }

  #modal_cores_negativas {
    animation-name: sliceLeft;
    animation-duration: 1s;
  }

  #modal_cores_cegas {
    animation-name: sliceLeft;
    animation-duration: 1s;
  }

  #modal_edit_cores {
    animation-name: sliceLeft;
    animation-duration: 1s;
  }

  #modal_cores_usadas {
    animation-name: sliceLeft;
    animation-duration: 1s;
  }

  #modal_cores_predom {
    animation-name: sliceLeft;
    animation-duration: 1s;
  }

  #modal_fatiada {
    animation-name: sliceLeft;
    animation-duration: 1s;
  }

  #modal_fim {
    animation-name: sliceLeft;
    animation-duration: 1s;
  }

  /* Animação para o Modal 2 */
  @keyframes sliceLeft {
    0% {
      opacity: 0;
      transform: translateX(100%);
    }

    100% {
      opacity: 1;
      transform: translateX(0%);
    }
  }

  #favicon {
    position: relative;
    top: 200px;
  }

  .logo {
    position: absolute;
    right: 406px;
    top: 0px;
  }

  h2 {
    position: relative;
    top: 20px;
    text-align: center;
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


  .button_next {
    position: fixed;
    bottom: 0;
    right: 0;
    padding: 10px;
  }

  #button_options {
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
    position: relative;
    top: 0;
    left: 10px;
    padding: 10px;
    box-shadow: 5px 4px 6px 4px #888888;
  }

  #button_options:hover {
    transform: translateY(-1px);
  }

  #button_options:active {
    background-color: #F0F0F1;
    border-color: rgba(0, 0, 0, 0.15);
    box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px;
    color: rgba(0, 0, 0, 0.65);
    transform: translateY(0);
  }

  #button_options:hover,
  #button_options:focus {
    border-color: rgba(0, 0, 0, 0.15);
    box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
    color: rgba(0, 0, 0, 0.65);
  }

  .buttonOptions[disabled] {
    cursor: not-allowed;
  }

  .centralizar_1_imagem {
    position: absolute;
    top: 0;
    bottom: 100px;
    left: 0;
    right: 0;
    margin: auto;
  }

  .options {
    display: none;
    position: relative;
    text-align: left;
    width: 10%;
    top: 10;
    left: 10;
    z-index: 25;
    background-color: whitesmoke;
    box-shadow: 5px 4px 6px 4px #888888;
  }


  #bottone5 {
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

  #bottone5:hover,
  #bottone5:focus {
    border-color: rgba(0, 0, 0, 0.15);
    box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
    color: rgba(0, 0, 0, 0.65);
  }

  #bottone5:hover {
    transform: translateY(-1px);
  }

  #bottone5:active {
    background-color: #F0F0F1;
    border-color: rgba(0, 0, 0, 0.15);
    box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px;
    color: rgba(0, 0, 0, 0.65);
    transform: translateY(0);
  }

  .buttonOptions {
    font-family: monospace;
    background-color: #f3f7fe;
    color: #3b82f6;
    border: none;
    border-radius: 8px;
    width: 100px;
    height: 45px;
    transition: .3s;
  }

  .buttonOptions:hover {
    background-color: #3b82f6;
    box-shadow: 0 0 0 5px #3b83f65f;
    color: #fff;
  }

  .size-button {
    font-family: monospace;
    background-color: #f3f7fe;
    color: #3b82f6;
    border: none;
    border-radius: 8px;
    width: 100px;
    height: 45px;
    transition: .3s;
  }

  .size-button:hover {
    background-color: #3b82f6;
    box-shadow: 0 0 0 5px #3b83f65f;
    color: #fff;
  }

  #valor-pixelizacao {
    display: none;
  }

  .slider-input {
    -webkit-appearance: none;
    width: 100%;
    height: 10px;
    border-radius: 5px;
    background: linear-gradient(to right, #3498db, #fff);
    outline: none;
    opacity: 0.7;
    transition: opacity .2s;
  }

  .slider-input:hover {
    opacity: 1;
  }

  .slider-input::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #3498db;
    cursor: pointer;
  }

  #imageSize {
    -webkit-appearance: none;
    width: 100%;
    height: 10px;
    border-radius: 5px;
    background: linear-gradient(to right, #3498db, #fff);
    outline: none;
    opacity: 0.7;
    transition: opacity .2s;
  }

  #imageSize:hover {
    opacity: 1;
  }

  #imageSize::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #3498db;
    cursor: pointer;
  }

  .small-table {
    margin-top: 100px;
    font-size: 12px;
    /* Reduzir o tamanho da fonte */
  }

  .small-table td,
  .small-table th {
    padding: 4px 8px 4px 8px;
    /* Reduzir o espaçamento de células */
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

  .table_2_img {
    position: absolute;
    top: 20%;
    left: 10%;
    margin: 0 auto;
    text-align: center;
    width: 80%;
    border-collapse: collapse;
    z-index: 1;
  }

  .table_2_img th {
    font-size: 30px;
  }

  .table_cores_cegas {
    position: relative;
    top: 150px;
    border: 1px solid black;
    margin: 0 auto;
    text-align: center;
    width: 80%;
    border-collapse: collapse;
  }

  .table_cores_cegas th {
    background-color: orangered;
  }

  .table_cores_cegas th,
  .table_cores_cegas td {
    padding: 10px;
    border: 1px solid black;
  }

  .table_cores_cegas th p,
  .table_cores_cegas td p {
    margin: 0;
    font-size: 16px;
    font-weight: bold;
    color: #333;
  }

  .table_cores_cegas img {
    width: 100%;
    max-width: 200px;
    height: auto;
  }

  .editcores-container {
    position: relative;
    left: 60px;
    top: 180px;
    display: flex;
    flex-direction: column;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    padding: 10px;
    border-radius: 5px;
    background-color: #f5f5f5;
    margin-bottom: 20px;
    width: 200px;
  }

  .editcores {
    position: relative;
    align-items: center;
    margin-bottom: 10px;
    margin-left: 10px;
    margin-right: 10px;
  }

  .editcores input[type="range"] {
    width: 150px;
    margin-right: 10px;
  }

  .editcores label {
    font-weight: bold;
  }

  .button_pre {
    position: fixed;
    bottom: 0;
    left: 0;
    padding: 10px;
  }
</style>


<body>

  <nav class="navbar">

    <a href="../pag_menuuser.php"><img src="../images/analogo.png" width="180" height="50" alt="AnaLogo"></a>

    <ul>
      <li><a href='../pag_menuuser.php'>Página Inicial<span class='sr-only'></span></a></li>
      <li><a href='pag_criarProjeto.php'>Carregar Marca Gráfica<span class='sr-only'></span></a></li>
      <li><a href='pag_histProjetos.php'>Histórico de Análise <span class='sr-only'></span></a></li>
      <li><a href='pag_verPerfil.php'>Ver Perfil <span class='sr-only'></span></a></li>
      <li><a href='../logout.php'>Desconectar <span class='sr-only'></span></a></li>
    </ul>
  </nav>



  <?php






  foreach ($opcoesEscolhidas as $opcao) {

    if ($opcao == 'original') {

      echo '<div class="modal " id="modal_' . $opcao . '">
              <h2>Marca Gráfica no Formato Original</h2>
              <img src= "../imagens/' . $logo . '"  class="centralizar_1_imagem" ' . $estilo . ' >

 
              <div class="button_next">
                <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1] : '') . '\')" >Abrir próxima análise</button>
              </div>
          </div>';
    }
    if ($opcao == 'pixelizado') {
      echo '<div class="modal " id="modal_' . $opcao . '">
            <h2>Marca Gráfica no Formato Pixelizado</h2>


            <table class="table_2_img">
              <tr>
                <th> <p> original </p> </th>
                <th> <p> pixelizada </p> </th>
              </tr>
              <tr>
                <td>  <img ' . $estilo . '  src="../imagens/' . $logo . '"></td>
                <div id="canvas-container">
                <td><canvas id="canvas" ' . $estilo . '> </canvas></td>
                </div>

              <button id="button_options" class="open-button1" onclick="openOptions()">Abrir Opções</button>

              <div class="options" id="myOptions">
                <br>
                <input class="slider-input" id="pixelizacao" type="range" min="0.1" max="10" value="1" step="0.1"> 
                <br>

                <button class="buttonOptions" id="btn-20">20%</button> <br>
                <button class="buttonOptions" id="btn-30">30%</button> <br>
                <button class="buttonOptions" id="btn-50">50%</button> <br>
                <button class="buttonOptions" id="btn-80">80%</button> <br>
                
                <span id="valor-pixelizacao">1</span>
                <button type="button" class="btn cancel" onclick="closeOptions()">Close</button>
                  
              </div>
            </table>
            
            <div class="button_next">
              <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1] : '') . '\')" >Abrir próxima análise</button>
            </div>

            <div class="button_pre">
              <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1] : '') . '\')" >Retroceder análise</button>
            </div>
          </div>';
    }
    if ($opcao == 'blur') {
      echo '<div class="modal" id="modal_' . $opcao . '">
            <h2>Marca Gráfica no Formato Blur</h2>

            <table class="table_2_img">
              <tr>
                <th> <p> original </p> </th>
                <th> <p> blur </p> </th>
              </tr>
              <tr>
                <td>  <img ' . $estilo . '  src="../imagens/' . $logo . '"></td>
                <td> <img src=../imagens/' . $logo . ' id="imagem" ' . $estilo . '> </td>
              </tr>
            </table>
            <button id="button_options" class="open-button1" onclick="openOptions2()">Abrir Opções</button>
    
            <div class="options" id="myOptions2">
                <br>
                <input class="slider-input" type="range" min="0" max="10" step="0.1" id="blur" oninput="updateBlur()"> 
                <br>
    
                <button class="buttonOptions" id="btn-20" value="2" type="button">20%</button>
                <br>
                <button class="buttonOptions" id="btn-30" value="3" type="button">30%</button>
                <br>
                <button class="buttonOptions" id="btn-50" value="5" type="button">50%</button>
                <br>
                <button class="buttonOptions" id="btn-80" value="8" type="button">80%</button>
                <br>
    
                <button type="button" class="btn cancel" onclick="closeLoginForm2()">Close</button>
            </div> 
    
            <div class="button_next">
                <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1] : '') . '\')">Abrir próxima análise</button>
            </div>

            <div class="button_pre">
              <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1] : '') . '\')" >Retroceder análise</button>
            </div>
        </div>';
    }
    if ($opcao == 'favicon') {
      echo '<div class="modal"  id="modal_' . $opcao . '">
              <h2>Marca Gráfica no Formato FavIcon</h2>
              
              <div id="favicon">
                  <img src="../imagens/favicon/' . $logo . '.png"   style="display: block; margin: 0 auto;">
              </div>    
                
              <div class="button_next">
                <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1] : '') . '\')" >Abrir próximo análise</button>
              </div>

              <div class="button_pre">
                <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1] : '') . '\')" >Retroceder análise</button>
              </div>
          </div>';
    }
    if ($opcao == 'tamanho') {
      echo '<div class="modal" id="modal_' . $opcao . '">
            <h2>Marca Gráfica no Formato Tamanho</h2>
    
            <button id="button_options" class="open-button1" onclick="openOptions3()">Abrir Opções</button>
    
            <div class="options" id="myOptions3">
                <br>
                <input type="range" min="5" max="100" value="40" class="slider" id="imageSize" oninput="updateSize()">
                <br>
    
                <button id="size-5" value="5" type="button" class="size-button">5%</button>
                <br>
                <button id="size-20" value="20" type="button" class="size-button">20%</button>
                <br>
                <button id="size-40" value="40" type="button" class="size-button">40%</button>
                <br>
                <button id="size-60" value="60" type="button" class="size-button">60%</button>
                <br>
                <button id="size-80" value="80" type="button" class="size-button">80%</button>
                <br>
    
                <button type="button" class="btn cancel" onclick="closeLoginForm3()">Close</button>
            </div>
    
            <img src="../imagens/' . $logo . '" id="myImage" style="padding-top: 40%; width: 50%;" class="centralizar_1_imagem">
            
            <div class="button_next">
                <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1] : '') . '\')">Abrir próximo análise</button>
            </div>

            <div class="button_pre">
              <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1] : '') . '\')" >Retroceder análise</button>
            </div>
        </div>';
    }

    if ($opcao == 'cores_negativas') {
      echo '<div class="modal" id="modal_' . $opcao . '">
            <h2>Marca Gráfica no Formato Cores Invertidas</h2>';

      echo '<table class="table_2_img">';
      echo '<tr>
                <th> <p> original </p> </th>
                <th> <p> cores invertidas </p> </th>
              </tr>
              <tr>
                <td>  <img ' . $estilo . '  src="../imagens/' . $logo . '"></td>
                <td> <img src="../imagens/negativo/Negativo' . $logo . '" ' . $estilo . ' "> </td>
              </tr>
            </table>';

      echo '            
            <div class="button_next">
              <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1] : '') . '\')" >Abrir próximo análise</button>
            </div>

            <div class="button_pre">
              <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1] : '') . '\')" >Retroceder análise</button>
            </div>
          </div>';
    }
    if ($opcao == 'cores_cegas') {
      echo '<div class="modal" id="modal_' . $opcao . '">
            <h2>Marca Gráfica no Formato de Daltonismo</h2>';

      echo '<table class="table_cores_cegas" >';
      echo '<tr>';
      echo '<th><p style="margin: 0; font-size: 16px; font-weight: bold; color: #333;">Orignal</p></th>';
      echo '<th><p style="margin: 0; font-size: 16px; font-weight: bold; color: #333;">Deutranopia</p></th>';
      echo '<th><p style="margin: 0; font-size: 16px; font-weight: bold; color: #333;">Correção para Deutranopia</p></th>';
      echo '<th><p style="margin: 0; font-size: 16px; font-weight: bold; color: #333;">Protanopia</p></th>';
      echo '<th><p style="margin: 0; font-size: 16px; font-weight: bold; color: #333;">Correção para Protanopia</p></th>';
      echo '<th><p style="margin: 0; font-size: 16px; font-weight: bold; color: #333;">Híbrida</p></th>';
      echo '<th><p style="margin: 0; font-size: 16px; font-weight: bold; color: #333;">Correção para Híbrida</p></th>';
      echo '<th><p style="margin: 0; font-size: 16px; font-weight: bold; color: #333;">Tritanopia</p></th>';
      echo '</tr>';
      echo '<tr>';
      echo '<td style="width: 100px;"><img style="width: 100%;" src="../imagens/' . $logo . '"></td>';
      echo '<td style="width: 100px;"><img style="width: 100%;" src="../imagens/daltonismo/' . $logo . '_deutranopia.png"></td>';
      echo '<td style="width: 100px;"><img style="width: 100%;" src="../imagens/daltonismo/' . $logo . '_CorrectingImageforDeutranopia.png"></td>';
      echo '<td style="width: 100px;"><img style="width: 100%;" src="../imagens/daltonismo/' . $logo . '_protanopia.png"></td>';
      echo '<td style="width: 100px;"><img style="width: 100%;" src="../imagens/daltonismo/' . $logo . '_CorrectingImageforProtanopia.png"></td>';
      echo '<td style="width: 100px;"><img style="width: 100%;" src="../imagens/daltonismo/' . $logo . '_hybrid.png"></td>';
      echo '<td style="width: 100px;"><img style="width: 100%;" src="../imagens/daltonismo/' . $logo . '_CorrectingImageforHybrid.png"></td>';
      echo '<td style="width: 100px;"><img style="width: 100%;" src="../imagens/daltonismo/' . $logo . '_tritanopia.png"></td>';
      echo '</tr>';
      echo '</table>';





      echo '

            <div class="button_next">
              <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1] : '') . '\')" >Abrir próximo análise</button>
            </div>

            <div class="button_pre">
              <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1] : '') . '\')" >Retroceder análise</button>
            </div>
          </div>';
    }

    if ($opcao == 'edit_cores') {
      echo '<div class="modal" id="modal_' . $opcao . '">
          <h2>Marca Gráfica no Formato Edição de Cores</h2>';

      ?>
      <div class="editcores-container">
        <div class="editcores">
          <input type="range" min="0" max="255" value="0" id="red-slider">
          <label for="red-slider">Red</label>
        </div>
        <div class="editcores">
          <input type="range" min="0" max="255" value="0" id="green-slider">
          <label for="green-slider">Green</label>
        </div>
        <div class="editcores">
          <input type="range" min="0" max="255" value="0" id="blue-slider">
          <label for="blue-slider">Blue</label>
        </div>
      </div>
      <?php

      echo '<table class="table_2_img">';
      echo '<tr>
                <th> <p> original </p> </th>
                <th> <p> cores invertidas </p> </th>
              </tr>
              <tr>
                <td>  <img ' . $estilo . '  src="../imagens/' . $logo . '"></td>
                <td> <canvas id="canvas2" ' . $estilo . ' ></canvas> </td>
              </tr>
            </table>';




      echo '

        <div class="button_next">
          <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1] : '') . '\')" >Abrir próximo análise</button>
        </div>

        <div class="button_pre">
            <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1] : '') . '\')" >Retroceder análise</button>
        </div>
        </div>';
    }

    if ($opcao == 'cores_usadas') {
      echo '<div class="modal" id="modal_' . $opcao . '">
      <h2>Cores Usadas na Marca Gráfica</h2>';

      $imagem = '../imagens/' . $logo;
      // Obtém as dimensões da imagem
      $imageSize = getimagesize($imagem);
      // Calcula o número total de pixels
  

      $levelPrecisao = 10;
      $palette = detectColors($imagem, 10, $levelPrecisao);
      echo '<img src=" ' . $imagem . ' " ' . $estilo . ' class="centralizar_1_imagem" >';
      echo '<div style="margin-top: 200px;">';
      echo '<table style="border-collapse: collapse;">';
      foreach ($palette as $color) {
        echo '<tr>';
        echo '<td style="width: 36px; height: 36px; background: #' . $color . ';"></td>';
        echo '<td style="padding-left: 10px;">#' . $color . '</td>';
        echo '</tr>';
      }
      echo '</table>';
      echo '</div>';


      echo '
    
      <div class="button_next">
        <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1] : '') . '\')" >Abrir próximo análise</button>
      </div>
    
      <div class="button_pre">
            <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1] : '') . '\')" >Retroceder análise</button>
      </div>

    </div>';
    }

    if ($opcao == 'cores_predom') {

      echo '<div class="modal" id="modal_' . $opcao . '">
      <h2>Cores Predominantes na Marca Gráfica</h2>';

      $imagem = '../imagens/' . $logo;
      // Obtém as dimensões da imagem
      $imageSize = getimagesize($imagem);
      // Calcula o número total de pixels
      $levelPrecisao = 10;

      $palette = detectColors($imagem, 3, $levelPrecisao);
      echo '<img src=" ' . $imagem . ' " ' . $estilo . ' class="centralizar_1_imagem" >';
      echo '<div style="margin-top: 200px;">';
      echo '<table style="border-collapse: collapse; ">';
      foreach ($palette as $color) {
        echo '<tr>';
        echo '<td style="width: 36px; height: 36px; background: #' . $color . ';"></td>';
        echo '<td style="padding-left: 10px;">#' . $color . '</td>';
        echo '</tr>';
      }
      echo '</table>';
      echo '</div>';

      echo '

      <div class="button_next">
          <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1] : '') . '\')" >Abrir próximo análise</button>
      </div>

      <div class="button_pre">
        <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1] : '') . '\')" >Retroceder análise</button>
      </div>

       </div>';

    }

    if ($opcao == 'fatiada') {

      echo '<div class="modal" id="modal_' . $opcao . '">
      <h2>Marca Gráfica Fatiada em 4 Peças</h2>';

      echo '<center>';
      echo '<table class="small-table">';

      echo '<tr >';
      echo '<td style="text-align: center; vertical-align: middle;"> Canto Superior Esquerdo <br><img src="../imagens/recortada/' . $logo . 'parte1.png" style="width:100%;" /></td>';
      echo '<td style="text-align: center; vertical-align: middle;"> Canto Inferior Direito <br><img src="../imagens/recortada/' . $logo . 'parte4.png" style="width:100%;" /></td>';
      echo '<td style="text-align: center; vertical-align: middle;"> Canto Superior Direito <br><img src="../imagens/recortada/' . $logo . 'parte2.png" style="width:100%;" /></td>';
      echo '<td style="text-align: center; vertical-align: middle;"> Canto Inferior Esquerdo <br><img src="../imagens/recortada/' . $logo . 'parte3.png" style="width:100%;" /></td>';
      echo '</tr>';
      echo '</table>';

      echo '</center>';
      echo '

            <div class="button_next">
              <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) + 1] : '') . '\')" >Abrir próximo análise</button>
            </div>


            <div class="button_pre">
              <button id="bottone5" onclick="abrirModal(\'' . $opcao . '\', \'' . (isset($opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1]) ? $opcoesEscolhidas[array_search($opcao, $opcoesEscolhidas) - 1] : '') . '\')" >Retroceder análise</button>
            </div>

           </div>';

    }


    if ($opcao == 'fim') {
      echo '<div class="modal" id="modal_fim">
            <h1> Clique para voltar </h1>
            <button id="bottone5" onclick="fecharModal()">Fechar</button>
          </div>';
    }
  }

  ?>


  <script> var nomeImagem = <?php echo json_encode('../imagens/' . $logo); ?>; </script>

  <script>
    // Verifica se existe um próximo modal a ser aberto
    function abrirModal(opcaoAtual, proximaOpcao) {
      if (proximaOpcao != '') {
        document.getElementById('modal_' + opcaoAtual).style.display = 'none';
        document.getElementById('modal_' + proximaOpcao).style.display = 'block';
      } else {
        // Se não houver mais modals, abre o modal final
        document.getElementById('modal_fim').style.display = 'block';
        document.getElementById('modal_<?php echo $opcao ?>').style.display = 'none';
      }
    }

    // Redireciona o usuário para a página inicial
    function fecharModal() {
      window.location.href = '../pag_menuuser.php';
    }
  </script>

  <script src='../script2.js'> </script>

  <script>
    function updateBlur() {
      var blur_value = document.getElementById("blur").value;
      document.getElementById("imagem").style.filter = "blur(" + blur_value + "px)";
    }

    function updateBlurFromButton(value) {
      document.getElementById("imagem").style.filter = "blur(" + value + "px)";
    }

    document.addEventListener("DOMContentLoaded", function (event) {
      var buttons = document.querySelectorAll(".buttonOptions");
      for (var i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener("click", function (event) {
          event.preventDefault();
          updateBlurFromButton(this.value);
        });
      }
    });

  </script>

  <script>
    let isButtonPressed = false;

    function updateSize() {
      const slider = document.querySelector(".slider");
      const imagem = document.getElementById("myImage");

      slider.addEventListener("input", () => {
        if (!isButtonPressed) {
          imagem.style.width = `${slider.value}%`;
        }
      });
    }

    const buttons = document.querySelectorAll(".size-button");
    buttons.forEach((button) => {
      button.addEventListener("mousedown", () => {
        isButtonPressed = true;
        const value = button.value;
        const imagem = document.getElementById("myImage");
        imagem.style.width = `${value}%`;
      });

      button.addEventListener("mouseup", () => {
        isButtonPressed = false;
      });
    });
  </script>



  <script src='../script4.js'></script>

  <script src="../script.js"> </script>


  <script>
    const navbarButton = document.querySelector('.navbar-toggler');
    const modal = document.querySelector('.modal');

    navbarButton.addEventListener('click', () => {
      modal.classList.toggle('top');
    });

  </script>


</body>

</html>