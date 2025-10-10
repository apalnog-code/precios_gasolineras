<?php

require_once 'conectar.php';
global $db;

$usuario = $_SESSION['usuario'];

echo "<h1>Bienvenido a LINDITEC</h1>";

if(isset($usuario)){
    echo "<p class='loginExitoso'>Conectado como ".$usuario['usuario']."</p>";
} 

if(isset($_POST['organizaciones'])){
    header('Location: organizaciones.php');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LINDITEC LOGIN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="css/styles.css">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="imagenes/logoims.png" />
</head>
<body>

    <form method="post" name="login" action="index.php">
        <button type="submit" name="organizaciones">Organizaciones</button>
    </form>
    
</body>
</html>