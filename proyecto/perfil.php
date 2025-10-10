<?php

require_once 'conectar.php';
global $db; 

if(isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];

    if(isset($_POST['guardar'])){

        $consultaGuardar = $db->prepare("UPDATE usuarios SET nombre = :nombre, apellido1 = :apellido1,  apellido2 = :apellido2, usuario = :usuario, nif = :nif, correo = :correo WHERE id = :id");
        $consultaGuardar->execute([
            ':nombre' => $_POST['nombre'],
            ':apellido1'=> $_POST['apellido1'],
            ':apellido2' =>$_POST['apellido2'],
            ':usuario' => $_POST['usuario'],
            ':nif'=> $_POST['nif'],
            ':correo' => $_POST['correo'],
            ':id' => $usuario['id']
        ]);
        
        $_SESSION['usuario']['usuario'] = $_POST['usuario'];

        header('Location: usuarios.php');
 
    } elseif(isset($_POST['cambiar'])){

        header('Location: cambiarpassword.php');

    }

} else {
    header("Location: login.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PORTADA</title>
    <link rel="stylesheet" href="css/informacion.css">
    <link rel="stylesheet" href="icomoon/style.css">
    <script src="js/funcionalidades.js"></script>
    <link rel="icon" type="image/png" href="imagenes/logoims.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Zalando+Sans:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    
    <div id="wrapper">
        <section>
            <div>
                <a href="http://localhost/proyecto/portada.php"><img src="imagenes/logoims.png" alt=""></a>
            </div>
            <ul>
                <li><a class="icon-users" href="http://localhost/proyecto/organizaciones.php">Organizaciones</a></li>
                <li><a class="icon-user" href="http://localhost/proyecto/usuarios.php">Usuarios</a></li>
                <li><a class="icon-files-empty" href="http://localhost/proyecto/puntosControl.php">Tipos de puntos de control</a></li>
                <li><a class="icon-office" href="http://localhost/proyecto/zonas.php">Zonas</a></li>
                <li><a class="icon-floppy-disk" href="http://localhost/proyecto/tiposTrabajo.php">Tipos de trabajo</a></li>
                <li><a class="icon-list2" href="http://localhost/proyecto/trabajos.php">Trabajos</a></li>
            </ul>
        </section>
        <aside>
            <div id="menuHamburguesa">
                <span>&#9776;</span>
                <div id="perfil">
                    <span class="icon-plus">Hola <?= $usuario['usuario'] ?></span>  
                    <div class="nover">
                        <ul>
                            <li><a href="perfil.php" class="icon-user">Mi perfil</a></li>
                            <li><a href="logout.php">Cerrar sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="configuracionPerfil">
                <h1>Tu perfil</h1>
                <main>
                <form action="" method="post">
                    <span>
                        <div>
                            <label>Nombre: </label>
                            <input type="text" name="nombre" value="<?= $usuario['nombre'] ?? "_" ?>">
                        </div>
                        <div>
                            <label>Primer apellido: </label>
                            <input type="text" name="apellido1" value="<?= $usuario['apellido1'] ?? "_" ?>" />
                        </div>
                        <div>
                            <label>Segundo apellido: </label>
                            <input type="text" name="apellido2" value="<?= $usuario['apellido2'] ?? "_"  ?>">
                        </div>
                    </span>
                    <span>
                        <div>
                            <label>Nombre de usuario: </label>
                            <input type="text" name="usuario" value="<?= $usuario['usuario'] ?? "_"  ?>">
                        </div>
                        <div>
                            <label>NIF: </label>
                            <input type="text" name="nif" value="<?= $usuario['nif'] ?? "_"  ?>" />
                        </div>
                        <div>
                            <label>Correo electrónico: </label>
                            <input type="text" name="correo" value="<?= $usuario['correo'] ?? "_"  ?>">
                        </div>
                    </span>
                            <button type="submit" id="guardar" name="guardar">Guardar cambios</button>
                            <button type="submit" id="cambiar" name="cambiar">Cambiar contraseña</button>                            
                    </form>
                </main>
            </div>
        </aside>
    </div>

</body>
</html>