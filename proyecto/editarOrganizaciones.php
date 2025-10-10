<?php

require_once 'conectar.php';
global $db;

if(isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $organizacion = $_SESSION['organizacion'];

    if(isset($_POST['cancelar'])){
        header('Location: organizaciones.php');
        exit();
    } elseif(isset($_POST['guardar'])){
        $consultaOrganizaciones = $db->prepare("UPDATE organizaciones SET nombre = :nombre, telefono = :telefono, nombrefiscal = :nombrefiscal, nif = :nif WHERE id = :id");
        $consultaOrganizaciones->execute([
            ':nombre' => $_POST['nombre'],
            ':telefono' => $_POST['telefono'],
            ':nombrefiscal' => $_POST['nombrefiscal'],
            ':nif' => $_POST['nif'],
            ':id' => $organizacion['id']
        ]);

        $consultaUsuarios = $db->prepare("UPDATE usuarios SET nombre = :nombreusuario, correo = :correo WHERE id = :id");
        $consultaUsuarios->execute([
            ':nombreusuario' => $_POST['nombreusuario'],
            ':correo' => $_POST['correo'],
            ':id' => $organizacion['usuario_id']
        ]);
        header('Location: organizaciones.php');
    }


} else {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar organizacion</title>
    <link rel="stylesheet" href="css/informacion.css">
    <link rel="stylesheet" href="css/organizaciones.css">
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
                <div id="configuracionOrganizacion">
                <h1>Editar organización</h1>
                <main>
                    <form action="" method="post">
                    <span>
                        <div>
                            <label>Nombre: </label>
                            <input type="text" name="nombre" value="<?= $organizacion['nombre'] ?? "_" ?>">
                        </div>
                        <div>
                            <label>Nombre fiscal: </label>
                            <input type="text" name="nombrefiscal" value="<?= $organizacion['nombrefiscal'] ?? "_" ?>" />
                        </div>
                    </span>
                    <span>
                        <div>
                            <label>NIF: </label>
                            <input type="text" name="nif" value="<?= $organizacion['nif'] ?? "_"  ?>">
                        </div>
                    </span>
                    <span>
                        <div>
                            <label>Persona de contacto: </label>
                            <input type="text" name="nombreusuario" value="<?= $organizacion['nombreusuario'] ?? "_"  ?>">
                        </div>
                        <div>
                            <label>Teléfono de contacto: </label>
                            <input type="text" name="telefono" value="<?= $organizacion['telefono'] ?? "_"  ?>" />
                        </div>
                        <div>
                            <label>Correo de contacto: </label>
                            <input type="text" name="correo" value="<?= $organizacion['correo'] ?? "_"  ?>">
                        </div>
                    </span>
                            <button type="submit" id="guardar" name="guardar">Guardar cambios</button>
                            <button type="submit" id="cancelar" name="cancelar">Cancelar y volver</button>                            
                        </form>
                </main>
            </div>
        </aside>
    </div>
</body>
</html>