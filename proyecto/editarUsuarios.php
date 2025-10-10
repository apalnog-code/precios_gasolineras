<?php

require_once 'conectar.php';
global $db;

if(isset($_SESSION['usuario'])){
    $usuario = $_SESSION['usuario'];
    $usuarioEditar = $_SESSION['usuarioEditar'];

    $consultaOrganizaciones = $db->prepare("SELECT * FROM organizaciones");
    $consultaOrganizaciones->execute();
    $organizaciones = $consultaOrganizaciones->fetchAll(PDO::FETCH_ASSOC);


    if(isset($_POST['cancelar'])){
        header('Location: usuarios.php');
    } elseif(isset($_POST['guardar'])){

        $password = $_POST['password'];
        $repitepassword = $_POST['repitepassword'];

        if ($password === $repitepassword) {

        $hash = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : $usuarioEditar['password'];

        $consultaEditarUsuario = $db->prepare("
            UPDATE usuarios 
            SET nombre = :nombre,
                apellido1 = :apellido1,
                apellido2 = :apellido2,
                usuario = :usuario,
                nif = :nif,
                correo = :correo,
                organizacion_id = :organizacion_id,
                activo = :activo,
                password = :password
                WHERE id = :id
        ");

        $consultaEditarUsuario->execute([
            ':nombre' => $_POST['nombre'],
            ':apellido1' => $_POST['apellido1'],
            ':apellido2' => $_POST['apellido2'],
            ':usuario' => $_POST['usuario'],
            ':nif' => $_POST['nif'],
            ':correo' => $_POST['correo'],
            ':organizacion_id' => $_POST['selectOrganizaciones'],
            ':activo' => $usuarioEditar['activo'],
            ':password' => $hash,
            ':id' => $usuarioEditar['id']
        ]);

        header('Location: usuarios.php');

    }
    
    } 
}

?>
<!DOCTYPE html> 
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="css/informacion.css">
    <link rel="stylesheet" href="css/organizaciones.css">
    <link rel="stylesheet" href="css/usuarios.css">
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
                <div id="configuracionUsuarios">
                <h1>Editar usuario</h1>
                <main>
                <form action="" method="post">
                    <span>
                        <div>
                            <label>Nombre: </label>
                            <input type="text" name="nombre" value="<?= $usuarioEditar['nombre'] ?>">
                        </div>
                        <div>
                            <label>Primer apellido: </label>
                            <input type="text" name="apellido1" value="<?= $usuarioEditar['apellido1'] ?>" />
                        </div>
                        <div>
                            <label>Segundo apellido: </label>
                            <input type="text" name="apellido2" value="<?= $usuarioEditar['apellido2'] ?>" />
                        </div>
                    </span>
                    <span>
                        <div>
                            <label>Nombre de usuario: </label>
                            <input type="text" name="usuario" value="<?= $usuarioEditar['usuario'] ?>">
                        </div>
                        <div>
                            <label>NIF: </label>
                            <input type="text" name="nif" value="<?= $usuarioEditar['nif'] ?>" />
                        </div>
                        <div>
                            <label>Correo electrónico: </label>
                            <input type="text" name="correo" value="<?= $usuarioEditar['correo'] ?>" />
                        </div>
                    </span>
                    <span>
                        <div>
                            <label>Contraseña: </label>
                            <input type="password" name="password" placeholder="Mayor a 3 caracteres" >
                        </div>
                        <div>
                            <label>Confirmar contraseña: </label>
                            <input type="password" name="repitepassword" placeholder="Mayor a 3 caracteres">
                        </div>
                    </span>
                    <span>
                        <div>
                            <label for="rol">Rol: </label>
                            <select name="roles" id="rol">
                                
                            </select>
                        </div>
                    </span>
                    <span>
                        <div>
                            <label for="organizaciones">Organizaciones: </label>
                            <select name="selectOrganizaciones" id="organizaciones">
                                <?php
                                foreach ($organizaciones as $key => $o) {
                                    echo "<option value='".$o['id']."'>".$o['nombre']."</option>";
                                }
                                ?>
                            </select>
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