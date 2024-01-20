<?php

session_start();

include '../validarConta.php';

if (!isset($_POST['projeto'])) {
    echo "<script>alert('Erro ao aceder à página!');</script>";
    echo '<script>window.location.href="logout.php";</script>';
}

if (!isset($_POST['logo'])) {
    echo "<script>alert('Erro ao aceder à página!');</script>";
    echo '<script>window.location.href="logout.php";</script>';
}


$projeto_id = $_POST['projeto'];
$id_user = $_SESSION['User_id'];



$original = 1; // obrigatorio aparecer
$pixelizado = isset($_POST['pixelizado']) ? 1 : 0; // verifica se a opção pixelizado foi selecionada
$blur = isset($_POST['blur']) ? 1 : 0; // verifica se a opção blur foi selecionada
$favicon = isset($_POST['favicon']) ? 1 : 0; // verifica se a opção favicon foi selecionada
$tamanho = isset($_POST['tamanho']) ? 1 : 0; // verifica se a opção tamanho foi selecionada
$cores_negativas = isset($_POST['cores_negativas']) ? 1 : 0; // verifica se a opção cores_negativas foi selecionada
$cores_cegas = isset($_POST['cores_cegas']) ? 1 : 0; // verifica se a opção cores_cegas foi selecionada
$edit_cores = isset($_POST['edit_Cores']) ? 1 : 0; // verifica se a opção edit_Cores foi selecionada
$cores_usadas = isset($_POST['cores_usadas']) ? 1 : 0; // verifica se a opção cores_usadas foi selecionada
$cores_predom = isset($_POST['cores_predom']) ? 1 : 0; // verifica se a opção cores_predom foi selecionada
$fatiada = isset($_POST['fatiada']) ? 1 : 0; // verifica se a opção fatiada foi selecionada


$logo = $_POST['logo'];




$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

if (!$conn) {
    die('Could not connect: ' . mysqli_error($conn));
}
mysqli_select_db($conn, 'analogo');


$sql = "UPDATE projeto SET original = ?, pixelizado = ?, blur = ?, favicon = ?, tamanho = ?, cores_negativas = ?, cores_cegas = ?, edit_cores = ?, cores_usadas = ?, cores_predom = ?, fatiada = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('iiiiiiiiiiii', $original, $pixelizado, $blur, $favicon, $tamanho, $cores_negativas, $cores_cegas, $edit_cores, $cores_usadas, $cores_predom, $fatiada, $projeto_id);
$res = $stmt->execute();
if (!$res) {
    die('Could not enter data: ' . $stmt->error);
}





$imagemRecortada;
function recortarImagem($imagePath)
{

    global $imagemRecortada;

    $ext = pathinfo($imagePath, PATHINFO_EXTENSION);
    if ($ext == "jpg" || $ext == "jpeg")
        $img = imagecreatefromjpeg($imagePath);
    elseif ($ext == "png")
        $img = imagecreatefrompng($imagePath);
    elseif ($ext == "gif")
        $img = imagecreatefromgif($imagePath);
    else
        echo 'Unsupported file extension';


    $width = imagesx($img);
    $height = imagesy($img);
    $xMin = $width;
    $xMax = 0;
    $yMin = $height;
    $yMax = 0;

    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $rgb = imagecolorat($img, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            if ($r !== 255 || $g !== 255 || $b !== 255) {
                if ($x < $xMin)
                    $xMin = $x;
                if ($x > $xMax)
                    $xMax = $x;
                if ($y < $yMin)
                    $yMin = $y;
                if ($y > $yMax)
                    $yMax = $y;
            }
        }
    }

    $newWidth = $xMax - $xMin;
    $newHeight = $yMax - $yMin;

    $newImg = imagecreatetruecolor($newWidth, $newHeight);
    imagecopy($newImg, $img, 0, 0, $xMin, $yMin, $newWidth, $newHeight);


    do {
        $rand = rand(5, 20000);
        $imagemRecortada = 'Recortada' . basename($imagePath, '.png') . $rand . '.png';
    } while (file_exists(__DIR__ . '/imagens/' . $imagemRecortada));

    imagepng($newImg, __DIR__ . '/../imagens/' . $imagemRecortada);

}




recortarImagem(__DIR__ . '/../' . $logo);

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

if (!$conn) {
    die('Could not connect: ' . mysqli_error($conn));
}
mysqli_select_db($conn, 'analogo');




$sql = "INSERT INTO logocarregada (Logo) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $imagemRecortada);
$res = $stmt->execute();
$logo_id = $conn->insert_id;




$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

if (!$conn) {
    die('Could not connect: ' . mysqli_error($conn));
}
mysqli_select_db($conn, 'analogo');



$bd = "INSERT INTO tb_factos (idLogo, idNavegador, idProjeto) VALUES (?, ?, ?)";
$stmt = $conn->prepare($bd);
$stmt->bind_param('iii', $logo_id, $id_user, $projeto_id);
$addbd = $stmt->execute();

if (!$addbd) {
    die('Could not enter data: ' . $stmt->error);
}


function negativo($image)
{



    $imagem = new Imagick(__DIR__ . '/../imagens/' . $image);
    $imagem->modulateImage(100, -100, 100);

    $imagem->setImageFormat('png');

    $imagemNegativo = 'Negativo' . $image;

    file_put_contents(__DIR__ . '/../imagens/negativo/' . $imagemNegativo, $imagem);

}

function daltonismo($imagemRecortada)
{
    $command = $command = 'C:/Users/solda/AppData/Local/Programs/Python/Python311/python.exe ' . __DIR__ . '/../run_examples.py ' . escapeshellarg($imagemRecortada);

    $output = shell_exec($command);

    echo $output;


}
function fatiar($logo)
{
    // Retirar fundo de imagem original
    $command = 'C:/Users/solda/AppData/Local/Programs/Python/Python311/python.exe removerFundo.py ' . escapeshellarg($logo);
    $fatiar = shell_exec($command);

    // Caminho para a imagem original
    $originalImagePath = __DIR__ . '/../imagens/' . $logo;

    // Abrir a imagem original
    $ext = pathinfo($originalImagePath, PATHINFO_EXTENSION);
    if ($ext == "jpg" || $ext == "jpeg")
        $img = imagecreatefromjpeg($originalImagePath);
    elseif ($ext == "png")
        $img = imagecreatefrompng($originalImagePath);
    elseif ($ext == "gif")
        $img = imagecreatefromgif($originalImagePath);
    else
        echo 'Unsupported file extension';

    // Obter as dimensões da imagem
    $width = imagesx($img);
    $height = imagesy($img);

    // Calcular as dimensões das partes
    $partWidth = $width / 2;
    $partHeight = $height / 2;

    // Função para criar uma imagem com fundo transparente
    function createTransparentImage($partWidth, $partHeight)
    {
        $image = imagecreatetruecolor($partWidth, $partHeight);
        imagealphablending($image, false);
        imagesavealpha($image, true);
        $transparentColor = imagecolorallocatealpha($image, 0, 0, 0, 127);
        imagefill($image, 0, 0, $transparentColor);
        return $image;
    }

    // Recortar e salvar as partes com fundo transparente
    $part1 = createTransparentImage($partWidth, $partHeight);
    $part2 = createTransparentImage($partWidth, $partHeight);
    $part3 = createTransparentImage($partWidth, $partHeight);
    $part4 = createTransparentImage($partWidth, $partHeight);

    imagecopyresampled($part1, $img, 0, 0, 0, 0, $partWidth, $partHeight, $partWidth, $partHeight);
    imagecopyresampled($part2, $img, 0, 0, $partWidth, 0, $partWidth, $partHeight, $partWidth, $partHeight);
    imagecopyresampled($part3, $img, 0, 0, 0, $partHeight, $partWidth, $partHeight, $partWidth, $partHeight);
    imagecopyresampled($part4, $img, 0, 0, $partWidth, $partHeight, $partWidth, $partHeight, $partWidth, $partHeight);

    imagepng($part1, __DIR__ . '/../imagens/recortada/' . $logo . 'parte1.png', 9);
    imagepng($part2, __DIR__ . '/../imagens/recortada/' . $logo . 'parte2.png', 9);
    imagepng($part3, __DIR__ . '/../imagens/recortada/' . $logo . 'parte3.png', 9);
    imagepng($part4, __DIR__ . '/../imagens/recortada/' . $logo . 'parte4.png', 9);
}

function favicon($imagemRecortada)
{
    // carregar as imagens
    $fundo = imagecreatefrompng(__DIR__ . '/../images/barra_de_pesquisa.png');
    $logotipo = imagecreatefrompng(__DIR__ . '/../imagens/' . $imagemRecortada);

    // definir a posição da imagem sobreposta
    $x = 968;
    $y = 8;

    // obter as dimensões originais do logotipo
    $largura_original = imagesx($logotipo);
    $altura_original = imagesy($logotipo);

    // calcular a nova altura mantendo a proporção original
    $nova_altura = min($altura_original, 24);
    $nova_largura = $nova_altura * $largura_original / $altura_original;

    // verificar se a nova largura é menor do que 24 pixels
    if ($nova_largura < 24) {
        // ajustar a posição horizontal para a direita
        $x = 968 + (16 - $nova_largura);
    }

    // redimensionar a imagem do logotipo
    $logotipo_redimensionado = imagecreatetruecolor($nova_largura, $nova_altura);
    imagecopyresampled($logotipo_redimensionado, $logotipo, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);

    // sobrepor a imagem redimensionada na imagem de fundo
    imagecopy($fundo, $logotipo_redimensionado, $x, $y, 0, 0, $nova_largura, $nova_altura);

    // salvar a imagem resultante
    imagepng($fundo, __DIR__ . '/../imagens/favicon/' . $imagemRecortada . '.png');

}

function pixelizarImagem($image, $pixelSize)
{
    $imagem = new Imagick(__DIR__ . '/../imagens/' . $image);

    $larguraOriginal = $imagem->getImageWidth();
    $alturaOriginal = $imagem->getImageHeight();

    $imagem->resizeImage($larguraOriginal / $pixelSize, $alturaOriginal / $pixelSize, Imagick::FILTER_POINT, 1);
    $imagem->resizeImage($larguraOriginal, $alturaOriginal, Imagick::FILTER_POINT, 1);

    $imagem->setImageFormat('png');


    $imagemPixelizada = $pixelSize . $image . 'Pixelizada.png';
    $caminhoGuardar = __DIR__ . '/../imagens/pixelizada/' . $imagemPixelizada;
    file_put_contents($caminhoGuardar, $imagem);
}



function fazerBlur($image, $grade)
{
    $imagem = new Imagick(__DIR__ . '/../imagens/' . $image);
    $imagem->gaussianBlurImage($grade, $grade);

    $imagem->setImageFormat('png');

    $imagemBlur = $grade . $image . 'Blur.png';

    $imagem->writeImage(__DIR__ . '/../imagens/blur/' . $imagemBlur);
}


$commands = array();

if ($original == 1) {
    $command = 'C:/Users/solda/AppData/Local/Programs/Python/Python311/python.exe removerFundo.py ' . escapeshellarg($imagemRecortada);
    $commands[] = $command;
}



if ($cores_cegas == 1) {
    $commands[] = daltonismo($imagemRecortada);
    $command2 = 'C:/Users/solda/AppData/Local/Programs/Python/Python311/python.exe testeRemoverImagem.py ' . escapeshellarg($imagemRecortada);
    $meh = shell_exec($command2);
    $commands[] = $meh;
}

if ($fatiada == 1) {
    $commands[] = fatiar($imagemRecortada);
}



$processes = array();
foreach ($commands as $command) {
    $processes[] = proc_open($command, array(), $pipes);
}

if ($favicon == 1) {
    $commands[] = favicon($imagemRecortada);
}

if ($cores_negativas == 1) {
    $commands[] = negativo($imagemRecortada);
}

if ($pixelizado == 1) {
    $commands[] = pixelizarImagem($imagemRecortada, 1.5);
    $commands[] = pixelizarImagem($imagemRecortada, 3.75);
    $commands[] = pixelizarImagem($imagemRecortada, 5.25);
    $commands[] = pixelizarImagem($imagemRecortada, 6);
}

if ($blur == 1) {
    $commands[] = fazerBlur($imagemRecortada, 10);
    $commands[] = fazerBlur($imagemRecortada, 8);
    $commands[] = fazerBlur($imagemRecortada, 5);
    $commands[] = fazerBlur($imagemRecortada, 3);
    $commands[] = fazerBlur($imagemRecortada, 2);
}

foreach ($processes as $process) {
    proc_close($process);
}

echo "<script LANGUAGE='JavaScript'>window.alert('Projeto Criado');window.location.href='../pag_menuuser.php';</script>";

?>