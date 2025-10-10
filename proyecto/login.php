<?php

require_once 'conectar.php';
global $db;


if (isset($_POST['entrar'])) {
    
    $usernameInput = $_POST['usuario'];
    $passwordInput = $_POST['passwd'];

    $consultaUsuarios = $db->prepare("SELECT * FROM usuarios");
    $consultaUsuarios->execute();
    $usuarios = $consultaUsuarios->fetchAll(PDO::FETCH_ASSOC);

    $valido = false;
    
    foreach ($usuarios as $key => $usuario) {

        if($usuario['correo'] == $usernameInput && password_verify($passwordInput, $usuario['password'])) {
            $_SESSION['usuario'] = $usuario;
            header("Location: portada.php");
            $valido = true;
            exit();
        }

    }

    if(!$valido){
        echo "<p class='error'>Credenciales incorrectas. Inténtelo de nuevo.</p>";
    }

}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LINDITEC LOGIN</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="imagenes/logoims.png" />
</head>
<body>
    <header>
        <img src="imagenes/logoims.png" alt="">
    </header>
    <main>
        <div>
            <span>Acceso</span>
            <form method="post" name="acceso" action="login.php">
                <p>
                    <label for="usuario" id="usuario">Acceso</label>
                    <input type="text" name="usuario" id="usuario" autofocus>
                </p>
                <p>
                    <label for="password" id="passwd">Contraseña</label>
                    <input type="password" name="passwd" id="password">
                </p>
                <p>
                    <button type="submit" name="entrar">Entrar</button>
                </p>
            </form>
        </div>
    </main>
</body>
</html>