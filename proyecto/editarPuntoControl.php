<?php

require_once 'conectar.php';
global $db;

if(isset($_SESSION['usuario'])){
    $usuario = $_SESSION['usuario'];
    $puntoControlEditar = $_SESSION['puntocontrolEditar'];

    $consultaOrganizaciones = $db->prepare("SELECT * FROM organizaciones");
    $consultaOrganizaciones->execute();
    $organizaciones = $consultaOrganizaciones->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST['cancelar'])){
        header('Location: puntosControl.php');
    } elseif(isset($_POST['guardar'])){

        $consultaUpdate = $db->prepare("UPDATE puntosControl SET nombre = :nombre, color = :color, organizacion_id = :organizacion_id WHERE id = :id");
        $consultaUpdate->execute([
            ':nombre' => $_POST['nombre'],
            ':color' => $_POST['color'],
            ':organizacion_id' => $_POST['organizacion'],
            ':id' => $puntoControlEditar['id']
        ]);

        header('Location: puntosControl.php');

    }
 
}

?>
<!DOCTYPE html> 
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="css/informacion.css">
        <link rel="stylesheet" href="css/puntoscontrol.css">
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
                <div id="configuracionPuntosControl">
                <h1>Editar punto de control</h1>
                <main>
                <form action="" method="post">
                    <span>
                        <div>
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" value='<?= $puntoControlEditar['nombre'] ?>'>                            
                        </div>
                    </span>
                    <span>
                        <div>
                            <label for="organizacion">Organización</label>
                            <select id="organizacion" name="organizacion" value='<?= $organizaciones[$puntoControlEditar['organizacion_id']] ?>'>
                                <?php
                                foreach ($organizaciones as $organizacion) {
                                    $selected = ($organizacion['id'] == $puntoControlEditar['organizacion_id']) ? 'selected' : '';
                                    echo "<option value='".$organizacion['id']."' $selected>".$organizacion['nombre']."</option>";
                                }
                                ?>
                            </select>                          
                        </div>
                    </span>
                    <span>
                        <div>
                            <label for="color">Color</label>
                            <input type="color" id="color" name="color" value='<?= $puntoControlEditar['color'] ?>'>                            
                        </div>
                    </span>
                    <span>
                        <button type="submit" id="guardar" name="guardar">Guardar cambios</button>
                        <button type="submit" id="cancelar" name="cancelar">Cancelar y volver</button>
                    </span>                          
                </form>
                </main>
            </div>
        </aside>
    </div>
</body>
</html>