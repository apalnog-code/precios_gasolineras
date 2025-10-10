<?php

require_once 'conectar.php';
global $db; 

if(isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];

    $consultaZonas = $db->prepare("SELECT z.*, o.nombre AS nombreorg FROM zona z JOIN organizaciones o WHERE o.id = z.organizacion_id");
    $consultaZonas->execute();
    $zonas = $consultaZonas->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST['add'])){
        $_SESSION['usuario'] = $usuario;
        header('Location: addzonas.php');
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
            <main id="menuTabla">
                <form method="post">
                <div>
                    <h1>Zonas</h1>
                    <button type="submit" name="add" id="add">+</button>                    
                </div>
                <div id="buscarMostrar">
                    <div>
                        <span>Mostrar</span>
                        <select name="selectFiltro" id="selectFiltro" name="selectFiltro">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span> registros</span>                        
                    </div>
                    <div>
                        <label for="buscar">Buscar: </label>
                        <input type="text" id="buscar">
                    </div>
                </div>

                <table>
                    <thead>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Localidad</th>
                        <th>Nº de puntos de control asignado</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        <?php
                        if(count($zonas) == 0){
                            echo "<tr><td colspan='7'>No hay datos que mostrar</td></tr>";
                        } else {
                            foreach ($zonas as $key => $zo) {
                                echo "<tr>";
                                echo "<td>".$zo['id']."</td>";
                                echo "<td>".$zo['nombreorg']."</td>";
                                echo "<td>".$zo['nombre']."</td>";
                                echo "<td>".$zo['descripcion']."</td>";
                                echo "<td>".$zo['localidad']." (".$zo['codigopostal'].") ".$zo['provincia']."</td>";
                                echo "<td>".($zo['puntos'] ?? "---")."</td>";
                                echo "<td><button id='editar' name='editar'>Editar</button></td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
                </form>
            </main>
        </aside>
    </div>

</body>
</html>