<?php

require_once 'conectar.php';
global $db;

if(isset($_SESSION['usuario'])){
    $usuario = $_SESSION['usuario'];
    $tipoTrabajoEditar = $_SESSION['tipoTrabajoEditar'];

    $consultaOrganizaciones = $db->prepare("SELECT * FROM organizaciones");
    $consultaOrganizaciones->execute();
    $organizaciones = $consultaOrganizaciones->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST['cancelar'])){
        header('Location: tiposTrabajo.php');
    } elseif(isset($_POST['guardar'])){

        $consultaUpdate = $db->prepare("UPDATE tipostrabajo SET nombre = :nombre, descripcion = :descripcion, organizacion_id = :organizacion_id WHERE id = :id");
        $consultaUpdate->execute([
            ':nombre' => $_POST['nombre'],
            ':descripcion' => $_POST['descripcion'],
            ':organizacion_id' => $_POST['organizacion'],
            ':id' => $tipoTrabajoEditar['id']
        ]);

        header('Location: tiposTrabajo.php');

    }
 
}

?>
<!DOCTYPE html> 
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="css/informacion.css">
        <link rel="stylesheet" href="css/tipotrabajo.css">
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
                <div id="configuracionTiposTrabajo">
                <h1>Editar tipo de trabajo</h1>
                <main>
                <form action="" method="post">
                    <span>
                        <div>
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" value='<?= $tipoTrabajoEditar['nombre'] ?>'>                            
                        </div>
                    </span>
                    <span>
                        <div>
                            <label for="organizacion">Organización</label>
                            <select id="organizacion" name="organizacion" value='<?= $organizaciones[$tipoTrabajoEditar['organizacion_id']] ?>'>
                                <?php
                                foreach ($organizaciones as $organizacion) {
                                    $selected = ($organizacion['id'] == $tipoTrabajoEditar['organizacion_id']) ? 'selected' : '';
                                    echo "<option value='".$organizacion['id']."' $selected>".$organizacion['nombre']."</option>";
                                }
                                ?>
                            </select>                          
                        </div>
                    </span>
                    <span>
                        <div>
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" id="descripcion"> <?= $tipoTrabajoEditar['descripcion'] ?> </textarea>
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