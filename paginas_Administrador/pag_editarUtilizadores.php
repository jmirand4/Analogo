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
    if (isset($_GET['id']))
        $id = $_GET['id'];
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
    </style>
    </head>

    <body>
        <?php include '../navbar/navbarAdministrador.html'; ?>

        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form action="../paginas_edicao/editarUser.php" method="POST">
                        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label for="username">Trocar Nome</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Trocar Nome">
                        </div>
                        <div class="form-group">
                            <label for="email">Trocar Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Trocar Email">
                        </div>
                        <div class="form-group">
                            <label for="password">Trocar Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Trocar Password">
                        </div>
                        <div class="form-group">
                            <label for="mudar_tipoUser">Mudar de Tipo</label>
                            <select class="form-control" id="mudar_tipoUser" name="mudar_tipoUser">
                                <option value=""></option>
                                <option value="2">Administrador</option>
                                <option value="0">Utilizador</option>
                                <option value="1">Utilizador Premium</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
            integrity="sha384-pzjw8+6hgkZztnl1rN6q+BrScdwFqXadz9q9H3gd8f8L3wJ2jWq5t0cyp5Q1DDM3"
            crossorigin="anonymous"></script>
    </body>

    </html>

    <?php
}
?>