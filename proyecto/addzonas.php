<?php

require_once 'conectar.php';
global $db;

if(isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];

    $consultaOrganizaciones = $db->prepare("SELECT * FROM organizaciones");
    $consultaOrganizaciones->execute();
    $organizaciones = $consultaOrganizaciones->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST['cancelar'])){
        header('Location: zonas.php');
    } elseif(isset($_POST['guardar'])){

        $consultaUpdate = $db->prepare("INSERT INTO zona (nombre, descripcion, localidad, codigopostal, latitud, longitud, organizacion_id, provincia) 
        VALUES (:nombre, :descripcion, :localidad, :codigopostal, :latitud, :longitud, :organizacion_id, :provincia)");

        $consultaUpdate->execute([
            ':nombre' => $_POST['nombre'],
            ':descripcion' => $_POST['descripcion'],
            ':localidad' => $_POST['localidadoculta'],
            ':codigopostal' => $_POST['codigopostal'],
            ':latitud' => $_POST['latitud'],
            ':longitud' => $_POST['longitud'],
            ':organizacion_id' => $_POST['organizacion'],
            ':provincia' => $_POST['provinciaoculta']
        ]);

        header('Location: zonas.php');

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
    <link rel="stylesheet" href="icomoon/style.css">
    <link rel="stylesheet" href="css/informacion.css">
    <link rel="stylesheet" href="css/add.css">
    <script src="js/funcionalidades.js"></script>
    <script src="js/provincias.js"></script>
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
            <main id="menuTabla">
            <form method="post">
                <h1>Registro de una zona</h1>
                <div id="entero">
                    <span>
                        <label for="organizacion">Organizaciones</label>
                        <p>
                            <select name="organizacion" id="organizacion">
                                    <?php
                                        foreach ($organizaciones as $key => $o) {
                                            echo "<option value='".$o['id']."'>".$o['nombre']."</option>";
                                        }
                                    ?>
                            </select>                                
                        </p>
                    </span>
                    <span>
                            <label for="nombre">Nombre</label>
                            <p>
                                <input type="text" name="nombre">                            
                            </p>
                    </span>
                    <span>
                            <label for="descripcion">Descripción</label>
                            <p>
                                <input type="text" name="descripcion">                            
                            </p>
                    </span>
                    <span>
                        <div id="superior">
                            <div>
                                <label for="provincia">Provincia</label>
                                <select name="provincia" id="provincia">
                                    
                                </select>                            
                            </div>
                            <div>
                                <label for="localidad">Localidad</label>
                                <select name="localidad" id="localidad">
                                        
                                </select>                                 
                            </div>
                        </div>
                    </span>
                    <span>
                        <label for="codigopostal">Código Postal</label>
                        <input type="text" name="codigopostal">                            
                    </span>
                    <span>
                        <div id="superior">
                            <div>
                                <label for="Latitud">Latitud</label>
                                <input type="text" name="latitud" id="latitud">     
                            </div>
                            <div>
                                <label for="longitud">Longitud</label>
                                <input type="text" name="longitud" id="longitud">     
                            </div>
                        </div>
                    </span>
                    <span>
                        <button type="submit" id="guardar" name="guardar">Guardar cambios</button>
                        <button type="submit" id="cancelar" name="cancelar">Cancelar y volver</button>
                    </span>  
                </div>

                <input type="hidden" name="provinciaoculta" value="" id="provinciaoculta">                
                <input type="hidden" name="localidadoculta" value="" id="localidadoculta">
                
            </form>
            </main>
        </aside>
    </div>

</body>
</html>