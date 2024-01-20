<?php
if (!isset($_SESSION)) {
    session_start();
}


include '../validarConta.php';

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

if (!$conn) {
    die('Could not connect: ' . mysqli_error($conn));
}
mysqli_select_db($conn, 'analogo');


//buscar user
$idUserAtual = $_SESSION['User_id'];
$idUser = mysqli_real_escape_string($conn, $idUserAtual); // prever sql injection

$sql = "SELECT id FROM navegador WHERE id = $idUser";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // id existe na bd
    $row = mysqli_fetch_assoc($result);
    $userID = $row['id']; // retorna id do user

} else {
    // ID nao existe na bd

}

// buscar projeto
if (isset($_GET['projeto'])) {
    $idProj = $_GET['projeto'];

    $idProjeto = mysqli_real_escape_string($conn, $idProj); // prever SQL injection

    $sql = "SELECT id FROM projeto WHERE id = $idProjeto";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // ID do projeto existe na base de dados
        $row = mysqli_fetch_assoc($result);
        $projetoID = $row['id']; // retorna o ID do projeto


    } else {
        // ID do projeto não existe na base de dados
    }
} else {
    // ID do projeto não foi fornecido
}



// Carregar o Composer
require_once 'dompdf/autoload.inc.php';

// Referenciar o namespace Dompdf
use Dompdf\Dompdf;

//if(isset($_SESSION['User'])){





include '../paginas_criarProjeto/detectColours.php';

// Incluir conexao com BD
include_once '../conexao.php';



// Instanciar e usar a classe dompdf
$dompdf = new Dompdf(['enable_remote' => true, 'isRemoteEnabled' => true]);

// QUERY para recuperar os registros do banco de dados

$sql = "SELECT logocarregada.Logo as Logo, navegador.name as nomeUser, projeto.nome as nome, projeto.original as original, projeto.pixelizado as pixelizado, projeto.blur as blur, projeto.favicon as favicon,projeto.tamanho as tamanho, 
    projeto.cores_negativas as cores_negativas, projeto.cores_cegas as cores_cegas, projeto.edit_cores as edit_cores, projeto.cores_usadas as cores_usadas, projeto.cores_predom as cores_predom, projeto.fatiada as fatiada 
    FROM navegador join tb_factos on navegador.id = tb_factos.idNavegador join projeto on projeto.id = tb_factos.idProjeto join logocarregada on logocarregada.id = tb_factos.idLogo where navegador.id = $userID and projeto.id=$projetoID";

$projetos = "SELECT projeto.original as original, projeto.pixelizado as pixelizado, projeto.blur as blur, projeto.favicon as favicon,projeto.tamanho as tamanho, projeto.cores_negativas as cores_negativas,
 projeto.cores_cegas as cores_cegas, projeto.edit_cores as edit_cores, projeto.cores_usadas as cores_usadas, projeto.cores_predom as cores_predom, projeto.fatiada as fatiada from projeto join tb_factos on projeto.id = tb_factos.idProjeto where projeto.id = $projetoID";
// Prepara a QUERY
$result = $conn->prepare($sql);

// Executar a QUERY
$result->execute();

$resultProjetos = $conn->prepare($projetos);

// Executar a QUERY
$resultProjetos->execute();

while ($row = $resultProjetos->fetch(PDO::FETCH_ASSOC)) {
    $dataProj[] = $row;
}

foreach ($dataProj as $row) {
    if ($row['original'] == 1) {
        $projetoOriginal = TRUE;
    } else {
        $projetoOriginal = FALSE;
    }

    if ($row['pixelizado'] == 1) {
        $projetoPixelizado = TRUE;
    } else {
        $projetoPixelizado = FALSE;
    }

    if ($row['blur'] == 1) {
        $projetoBlur = TRUE;
    } else {
        $projetoBlur = FALSE;
    }

    if ($row['favicon'] == 1) {
        $projetoFavicon = TRUE;
    } else {
        $projetoFavicon = FALSE;
    }

    if ($row['tamanho'] == 1) {
        $projetoTamanho = TRUE;
    } else {
        $projetoTamanho = FALSE;
    }

    if ($row['cores_negativas'] == 1) {
        $projetoCores_Negativas = TRUE;
    } else {
        $projetoCores_Negativas = FALSE;
    }

    if ($row['cores_cegas'] == 1) {
        $projetoCores_Cegas = TRUE;
    } else {
        $projetoCores_Cegas = FALSE;
    }

    if ($row['edit_cores'] == 1) {
        $projetoEdit_Cores = TRUE;
    } else {
        $projetoEdit_Cores = FALSE;
    }

    if ($row['cores_usadas'] == 1) {
        $projetoCores_Usadas = TRUE;
    } else {
        $projetoCores_Usadas = FALSE;
    }

    if ($row['cores_predom'] == 1) {
        $projetoCores_Predom = TRUE;
    } else {
        $projetoCores_Predom = FALSE;
    }

    if ($row['fatiada'] == 1) {
        $projetoFatiada = TRUE;
    } else {
        $projetoFatiadas = FALSE;
    }

}
// Informacoes para o PDF
$dados = "<!DOCTYPE html>";
$dados .= "<html lang='pt-pt'>";
$dados .= "<head>";
$dados .= "<meta charset='UTF-8'>";
$dados .= "</head>";
$dados .= "<style>

body {
    background-color: white;
}

#favicon {
    width: 100%;
}

#fatiada {
    font-size: 11px;
}

table.greyGridTable {
  border: 2px solid #FFFFFF;
  text-align: center;
  border-collapse: collapse;
}

table.greyGridTable td, table.greyGridTable th {
  border: 1px solid #FFFFFF;
  padding: 3px 4px;
}

table.greyGridTable tbody td {
  font-size: 13px;
}

table.greyGridTable td:nth-child(even) {
  background: #EBEBEB;
}

table.greyGridTable thead {
  background: #FFFFFF;
  border-bottom: 4px solid #333333;
}

table.greyGridTable thead th {
  font-size: 15px;
  font-weight: bold;
  color: #333333;
  text-align: center;
  border-left: 2px solid #333333;
}

table.greyGridTable thead th:first-child {
  border-left: none;
}
  
table.greyGridTable tfoot {
  font-size: 14px;
  font-weight: bold;
  color: #333333;
  border-top: 4px solid #333333;
}

table.greyGridTable tfoot td {
  font-size: 14px;
}

table {
    width: 80%;
    border-collapse: collapse;
    margin: auto;
}

th, td {
    border: 1px solid black;
    padding: 15px;
    text-align: center;
}

</style>";

$dados .= "<body>";

$dados .= "<img width='100%' height='100%' src=http://localhost/WebApp1/images/Manual%20_de_Normas_Gráficas.png>";

$dados .= "<h1> Normas Gráficas da Marca Gráfica </h1>";
$dados .= "<h2> Introdução </h2>";
$dados .= "<p>Este guia de normas gráficas fornecerá informações detalhadas para análise e teste da marca gráfica [nome da empresa] de maneira consistente e eficaz. Essas diretrizes ajudarão a garantir que a marca gráfica seja apresentada de maneira uniforme e reconhecível em todas as plataformas e materiais de marketing.</p>";

$dados .= "<br><br>";



if ($projetoOriginal == TRUE || $projetoTamanho == TRUE || $projetoCores_Usadas == TRUE || $projetoCores_Predom == TRUE) {
    $dados .= "<h2>Logo Principal</h2>
<p>A versão principal da marca gráfica é a versão mais utilizada e deve ser usada sempre que possível. Esta secção oferece algumas modificações na marca gráfica no que toca, por exemplo, ao tamanho e cores principais e predominantes captadas.</p>";


    // Ler os registos retornado da BD
    $data = array();




    if ($projetoOriginal == TRUE) {

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        foreach ($data as $row) {
            extract($row);
            $dados .= "<h3>" . "Marca gráfica" . "</h3>";
            $dados .= "<br>";
            $dados .= "<img class='size' src='http://localhost/WebApp1/imagens/" . $row['Logo'] . "' style='width: 100%; margin: 0;'>";

        }
    }

    $dados .= "<br>";
    $dados .= "<br>";

    if ($projetoTamanho == TRUE) {
        $dados .= "<h3> Marca Gráfica em Tamanhos Diferentes </h3>";
        $dados .= "<br>";

        $dados .= "<center>";

        $dados .= "<div>";
        $dados .= "<img width='5%' src='http://localhost/WebApp1/imagens/" . $row['Logo'] . "'style='width: 5%; margin: 0;'>";
        $dados .= "<p>Marca Gráfica em 5% da página</p>";
        $dados .= "</div>";


        $dados .= "<div>";
        $dados .= "<img width='10%' src='http://localhost/WebApp1/imagens/" . $row['Logo'] . "'style='width: 10%; margin: 0;'>";
        $dados .= "<p>Marca Gráfica em 10% da página</p>";
        $dados .= "</div>";

        $dados .= "<div>";
        $dados .= "<img width='20%' src='http://localhost/WebApp1/imagens/" . $row['Logo'] . "'style='width: 20%; margin: 0;'>";
        $dados .= "<p>Marca Gráfica em 20% da página</p>";
        $dados .= "</div>";

        $dados .= "<div>";
        $dados .= "<img width='40%' src='http://localhost/WebApp1/imagens/" . $row['Logo'] . "'style='width: 40%; margin: 0;'>";
        $dados .= "<p>Marca Gráfica em 40% da página</p>";
        $dados .= "</div>";

        $dados .= "<div>";
        $dados .= "<img width='60%' src='http://localhost/WebApp1/imagens/" . $row['Logo'] . "'style='width: 60%; margin: 0;'>";
        $dados .= "<p>Marca Gráfica em 60% da página</p>";
        $dados .= "</div>";

        $dados .= "<div>";
        $dados .= "<img width='80%' src='http://localhost/WebApp1/imagens/" . $row['Logo'] . " 'style='width: 80%; margin: 0;'>";
        $dados .= "<p>Marca Gráfica em 80% da página</p>";
        $dados .= "</div>";

        $dados .= "</center>";


    }

    $dados .= "<br>";
    $dados .= "<br>";

    if ($projetoCores_Usadas == TRUE) {

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        foreach ($data as $row) {
            $imagem = '../imagens/' . $row['Logo'];

            //imagem com muitos pixels n funciona, melhorar isto
            $levelPrecisao = 10;

            $palette = detectColors($imagem, 10, $levelPrecisao);

            $dados .= "<h3>" . "Cores Usadas" . "</h3>";

            $dados .= "<center>";
            $dados .= '<table class="greyGridTable">
                <thead>
                    <tr>
                        <th>Cor</th>
                        <th>Formato Hexadecimal</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($palette as $color) {
                list($r, $g, $b) = hexToRgb($color);
                // $dados .= '<td> ola'.$color .'</td>';
                $dados .= '<tr><td style="background-color:rgb(' . $r . ',' . $g . ',' . $b . '); width:36px;"></td><td>#' . $color . '</td></tr>';
            }
            $dados .= '</tbody>';
            $dados .= "</table>";
            $dados .= "</center>";
        }
    }

    $dados .= "<br>";
    $dados .= "<br>";

    if ($projetoCores_Predom == TRUE) {

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        foreach ($data as $row) {
            $imagem = '../imagens/' . $row['Logo'];


            // Obtém as dimensões da imagem
            $imageSize = getimagesize($imagem);
            // Calcula o número total de pixels
            $numPixels = $imageSize[0] * $imageSize[1];

            if ($numPixels > 100000) {
                $numPixels = 50000;
            }

            //imagem com muitos pixels n funciona, melhorar isto
            $levelPrecisao = ($numPixels * 30) / 32391;



            $palette = detectColors($imagem, 3, $levelPrecisao);
            $dados .= "<h3>" . "Cores Predominantes" . "</h3>";

            $dados .= "<center>";
            $dados .= '<table class="greyGridTable">
                <thead>
                    <tr>
                        <th>Cor</th>
                        <th>Formato Hexadecimal</th>
                    </tr>
                </thead>
                <tbody>';


            foreach ($palette as $color) {
                list($r, $g, $b) = hexToRgb($color);
                $dados .= '<tr><td style="background-color:rgb(' . $r . ',' . $g . ',' . $b . '); width:36px;"></td><td>#' . $color . '</td></tr>';
            }
            $dados .= '</tbody>';
            $dados .= "</table>";
            $dados .= "</center>";
        }
    }

    $dados .= "<br>";
    $dados .= "<br>";
}

if ($projetoPixelizado == TRUE || $projetoBlur == TRUE || $projetoFavicon == TRUE) {
    $dados .= "<h2>Variações da Marca Gráfica</h2>
<p>Além da versão principal do logotipo, também existem outras variações que podem ser usadas em situações específicas. Essa secção abrange as variações do tipo pixelizada, com efeito blur e favicon.</p>";

    if ($projetoPixelizado == TRUE) {
        foreach ($data as $row) {
            extract($row);
            $dados .= "<h3> Pixelizado </h3>";
            $dados .= "<br>";
            $dados .= "<img class='size' id='pixel' style='width: 50%; margin: 0;' src=http://localhost/WebApp1/imagens/pixelizada/6" . $row['Logo'] . "Pixelizada.png>";
            $dados .= "<img class='size' id='pixel' style='width: 50%; margin: 0;' src=http://localhost/WebApp1/imagens/pixelizada/5.25" . $row['Logo'] . "Pixelizada.png>";
            $dados .= "<img class='size' id='pixel' style='width: 50%; margin: 0;' src=http://localhost/WebApp1/imagens/pixelizada/3.75" . $row['Logo'] . "Pixelizada.png>";
            $dados .= "<img class='size' id='pixel' style='width: 50%; margin: 0;' src=http://localhost/WebApp1/imagens/pixelizada/1.5" . $row['Logo'] . "Pixelizada.png>";
        }
    }

    $dados .= "<br>";
    $dados .= "<br>";

    if ($projetoBlur == TRUE) {
        foreach ($data as $row) {
            extract($row);
            $dados .= "<h3>" . "Blur" . "</h3>";
            $dados .= "<br>";
            $dados .= "" . "<img class='size' id='pixel' style='width: 50%; margin: 0;' src=http://localhost/WebApp1/imagens/blur/2" . $row['Logo'] . "Blur.png>" . "";
            $dados .= "" . "<img class='size' id='pixel' style='width: 50%; margin: 0;' src=http://localhost/WebApp1/imagens/blur/3" . $row['Logo'] . "Blur.png>" . "";
            $dados .= "" . "<img class='size' id='pixel' style='width: 50%; margin: 0;' src=http://localhost/WebApp1/imagens/blur/5" . $row['Logo'] . "Blur.png>" . "";
            $dados .= "" . "<img class='size' id='pixel' style='width: 50%; margin: 0;' src=http://localhost/WebApp1/imagens/blur/8" . $row['Logo'] . "Blur.png>" . "";
            $dados .= "" . "<img class='size' id='pixel' style='width: 50%; margin: 0;' src=http://localhost/WebApp1/imagens/blur/10" . $row['Logo'] . "Blur.png>" . "";
        }
    }

    $dados .= "<br>";
    $dados .= "<br>";



    if ($projetoFavicon == TRUE) {
        foreach ($data as $row) {
            $dados .= "<h3>" . "FavIcon" . "</h3>";

            $dados .= "" . "<img id='favicon' style='width: 100%; margin: 0;' src=http://localhost/WebApp1/imagens/favicon/" . $row['Logo'] . ".png>" . "";

        }
    }

    $dados .= "<br>";
    $dados .= "<br>";

}

if ($projetoCores_Negativas == TRUE) {


    $dados .= "<h2>Imagens com Cores Negativas</h2>
<p>A versão com cores negativas da marca gráfica é uma opção útil caso as cores não possam ser usadas ou não sejam adequadas. Esta secção mostra a versão com cores invertidas da marca gráfica para que o utilizador possa retirar suas próprias conclusões.</p>";

    $dados .= "<h3> Cores Negativas </h3>";
    $dados .= "<br>";
    foreach ($data as $row) {
        $dados .= "<center>";
        $dados .= "<img style='width: 100%; margin: 0;' src=http://localhost/WebApp1/imagens/negativo/Negativo" . $row['Logo'] . ">";
        $dados .= "</center>";
    }


    $dados .= "<br>";
    $dados .= "<br>";

}

if ($projetoCores_Cegas == TRUE) {


    $dados .= "<h2>Cegueira de Cores</h2>
<p>A cegueira de cores é uma condição visual comum que afeta a capacidade de algumas pessoas de distinguir certas cores. Aqui são demonstradas várias versões da marca gráfica original para garantir que o mesmo seja acessível e legível para todos.</p>";



    $dados .= "<h3> Cegueira de Cores </h3>";
    $dados .= "<br>";
    foreach ($data as $row) {

        $dados .= "<img style='width: 100%; margin: 0;' src=http://localhost/WebApp1/imagens/daltonismo/" . $row['Logo'] . "_deutranopia.png>";
        $dados .= "<p>Deutranopia</p>";

        $dados .= "<img style='width: 100%; margin: 0;' src=http://localhost/WebApp1/imagens/daltonismo/" . $row['Logo'] . "_CorrectingImageforDeutranopia.png>";
        $dados .= "<p>Correcting Image for Deutranopia</p>";

        $dados .= "<img style='width: 100%; margin: 0;' src=http://localhost/WebApp1/imagens/daltonismo/" . $row['Logo'] . "_protanopia.png>";
        $dados .= "<p>Protanopia</p>";

        $dados .= "<img style='width: 100%; margin: 0;' src=http://localhost/WebApp1/imagens/daltonismo/" . $row['Logo'] . "_CorrectingImageforProtanopia.png>";
        $dados .= "<p>Correcting Image for Protanopia</p>";

        $dados .= "<img style='width: 100%; margin: 0;' src=http://localhost/WebApp1/imagens/daltonismo/" . $row['Logo'] . "_hybrid.png>";
        $dados .= "<p>Hybrid</p>";

        $dados .= "<img style='width: 100%; margin: 0;' src=http://localhost/WebApp1/imagens/daltonismo/" . $row['Logo'] . "_CorrectingImageforHybrid.png>";
        $dados .= "<p>Correcting Image for Hybrid</p>";

        $dados .= "<img style='width: 100%; margin: 0;' src=http://localhost/WebApp1/imagens/daltonismo/" . $row['Logo'] . "_tritanopia.png>";
        $dados .= "<p>Tritanopia</p>";
    }


    $dados .= "<br>";
    $dados .= "<br>";

}



if ($projetoFatiada == TRUE) {


    $dados .= "<h2>Marca Gráfica Fatiada</h2>
<p>Às vezes, é necessário cortar ou dividir a marca gráfica em partes para se adequar a certas aplicações. Por fim, este demonstra um recorte sobre como a marca gráfica para testar a legibilidade do mesmo para opter o resultado de manter a legibilidade e a integridade da marca.</p>";




    $dados .= "<h3> Fatiada </h3>";
    $dados .= "<table>";

    foreach ($data as $row) {

        $dados .= '<tr>';
        $dados .= "<td>";
        $dados .= "<img width='60%' src='http://localhost/WebApp1/imagens/recortada/" . $row['Logo'] . "parte1.png'>";
        $dados .= "<p id='fatiada'> 2º Quadrante</p>";
        $dados .= "</td>";

        $dados .= '<td>
                        <img width="60%"" src="http://localhost/WebApp1/imagens/recortada/' . $row["Logo"] . 'parte2.png" alt="1º Quadrante">
                        <p id="fatiada">1º Quadrante</p>
                    </td>
                    </tr>
                    <tr>
                    <td>
                        <img  width="60%" src="http://localhost/WebApp1/imagens/recortada/' . $row["Logo"] . 'parte3.png" alt="3º Quadrante">
                        <p id="fatiada">3º Quadrante</p>
                    </td>
                    <td>
                        <img width="60%" src="http://localhost/WebApp1/imagens/recortada/' . $row["Logo"] . 'parte4.png" alt="4º Quadrante">
                        <p id="fatiada">4º Quadrante</p>
                    </td>
                    </tr>';
    }
    $dados .= '</table>';

}


$dados .= "</body>";

// Instanciar o metodo loadHtml e enviar o conteudo do PDF
$dompdf->loadHtml($dados);

// Configurar o tamanho e a orientacao do papel
// landscape - Imprimir no formato paisagem
//$dompdf->setPaper('A4', 'landscape');
// portrait - Imprimir no formato retrato
$dompdf->setPaper('A4', 'portrait');

// Renderizar o HTML como PDF
$dompdf->render();

// Gerar o PDF
$dompdf->stream();