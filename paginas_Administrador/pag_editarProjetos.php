<?php
session_start();

include '../validarConta.php';

$user_id = $_SESSION['User_id'];

$verificarTipoUser = "SELECT tipoUser FROM navegador WHERE id = ?";
$stmt = mysqli_prepare($conn, $verificarTipoUser);
mysqli_stmt_bind_param($stmt, "s", $user_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

if (!$res) {
    die('Could not get data: ' . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($res);
$tipoUser = $row['tipoUser'];

if ($tipoUser != 2) {
    echo "<script>alert('Sem Permissões para aceder a página ou Página não Existe!');</script>";
    echo '<script>window.location.href="../logout.php";</script>';
} else {

    if (isset($_POST['projeto_id'])) {
        $idProjeto = $_POST['projeto_id'];
    }
    ?>

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

            .form-container {
                max-width: 500px;
                margin: 0 auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .form-container h2 {
                text-align: center;
                margin-bottom: 20px;
            }

            .form-container label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
            }

            .form-container input[type="text"],
            .form-container select {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 3px;
                margin-bottom: 10px;
            }

            .form-container .options-container {
                margin-bottom: 20px;
            }

            .form-container .options-container label {
                display: inline-block;
                margin-right: 10px;
            }

            .form-container .buttons-container {
                text-align: center;
            }
        </style>
    </head>

    <body>

    <?php include '../navbar/navbarAdministrador.html'; ?>

        <?php
        $dbhost = 'localhost';
        $dbuser = 'root';
        $dbpass = '';
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, 'analogo');
        if (!$conn) {
            die('Could not connect: ' . mysqli_error($conn));
        }

        $sql = "SELECT * FROM navegador";

        $retval2 = mysqli_query($conn, $sql);

        $verOpcoes = "SELECT projeto.original AS original, projeto.pixelizado AS pixelizado, projeto.blur AS blur,projeto.favicon AS favicon, projeto.tamanho AS tamanho, projeto.cores_negativas AS cores_negativas, projeto.edit_cores AS edit_cores,
    projeto.cores_cegas AS cores_cegas, projeto.cores_predom AS cores_predom, projeto.cores_usadas AS cores_usadas, projeto.fatiada AS fatiada FROM projeto INNER JOIN tb_factos ON projeto.id = tb_factos.idProjeto WHERE tb_factos.idProjeto = ?";
        $stmt2 = mysqli_prepare($conn, $verOpcoes);
        mysqli_stmt_bind_param($stmt2, "s", $idProjeto);
        mysqli_stmt_execute($stmt2);
        $retval3 = mysqli_stmt_get_result($stmt2);

        // Inicializar as variáveis para armazenar os valores recuperados do banco de dados
        $original = 0;
        $pixelizado = 0;
        $blur = 0;
        $favicon = 0;
        $tamanho = 0;
        $cores_negativas = 0;
        $cores_cegas = 0;
        $edit_cores = 0;
        $cores_usadas = 0;
        $cores_predom = 0;
        $fatiada = 0;

        // Verificar se os valores foram encontrados no banco de dados
        if (mysqli_num_rows($retval3) > 0) {
            $row = mysqli_fetch_assoc($retval3);

            // Atribuir os valores às variáveis correspondentes
            $original = $row['original'];
            $pixelizado = $row['pixelizado'];
            $blur = $row['blur'];
            $favicon = $row['favicon'];
            $tamanho = $row['tamanho'];
            $cores_negativas = $row['cores_negativas'];
            $cores_cegas = $row['cores_cegas'];
            $edit_cores = $row['edit_cores'];
            $cores_usadas = $row['cores_usadas'];
            $cores_predom = $row['cores_predom'];
            $fatiada = $row['fatiada'];
        }

        ?>

        <div class="form-container">
            <h2>Editar Projeto</h2>
            <form action="../paginas_edicao/editar.php" method="POST">
                <div class="form-group">
                    <label for="nome_projeto">Novo Nome</label>
                    <input type="text" class="form-control" id="nome_projeto" name="projeto" placeholder="Novo Nome">
                    <input type="hidden" name="id" id="id" value="<?php echo $idProjeto; ?>">
                </div>
                <div class="form-group">
                    <h5>Opções:</h5>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="pixelizado" name="pixelizado" value="pixelizado"
                            <?php if ($pixelizado == 1)
                                echo 'checked'; ?>>
                        <label class="form-check-label" for="pixelizado">Pixelizado</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="blur" name="blur" value="blur" <?php if ($blur == 1)
                            echo 'checked'; ?>>
                        <label class="form-check-label" for="blur">Blur</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="favicon" name="favicon" value="favicon" <?php if ($favicon == 1)
                            echo 'checked'; ?>>
                        <label class="form-check-label" for="favicon">Favicon</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tamanho" name="tamanho" value="tamanho" <?php if ($tamanho == 1)
                            echo 'checked'; ?>>
                        <label class="form-check-label" for="tamanho">Tamanho</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="cores_negativas" name="cores_negativas"
                            value="cores_negativas" <?php if ($cores_negativas == 1)
                                echo 'checked'; ?>>
                        <label class="form-check-label" for="cores_negativas">Cores Negativas</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="cores_cegas" name="cores_cegas"
                            value="cores_cegas" <?php if ($cores_cegas == 1)
                                echo 'checked'; ?>>
                        <label class="form-check-label" for="cores_cegas">Cores Cegas</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="edit_cores" name="edit_cores" value="edit_cores"
                            <?php if ($edit_cores == 1)
                                echo 'checked'; ?>>
                        <label class="form-check-label" for="edit_cores">Edit Cores</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="cores_usadas" name="cores_usadas"
                            value="cores_usadas" <?php if ($cores_usadas == 1)
                                echo 'checked'; ?>>
                        <label class="form-check-label" for="cores_usadas">Cores Usadas</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="cores_predom" name="cores_predom"
                            value="cores_predom" <?php if ($cores_predom == 1)
                                echo 'checked'; ?>>
                        <label class="form-check-label" for="cores_predom">Cores Predominantes</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="fatiada" name="fatiada" value="fatiada" <?php if ($fatiada == 1)
                            echo 'checked'; ?>>
                        <label class="form-check-label" for="fatiada">Fatiada</label>
                    </div>
                </div>
                <input type="hidden" name="projeto_id" value="<?php echo $idProjeto; ?>">
                <div class="buttons-container">
                    <button type="submit" class="btn btn-primary">Editar Projeto</button>
                    <a href="pag_listarProjetos.php" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>

    </body>

    </html>
    <?php
}
?>