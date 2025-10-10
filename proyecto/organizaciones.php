<?php

require_once 'conectar.php';
global $db; 

if(isset($_SESSION['usuario'])) {

    $usuario = $_SESSION['usuario'];

    $consulta = $db->prepare("
        SELECT 
            o.*, 
            u.nombre AS nombreusuario, 
            u.correo,
            (
                SELECT COUNT(*) 
                FROM usuarios us 
                WHERE us.organizacion_id = o.id AND us.activo = 1
            ) AS usuarios_activos
        FROM organizaciones o
         JOIN usuarios u ON o.usuario_id = u.id
    ");
    $consulta->execute();
    $organizaciones = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
    if(isset($_POST['editar'])){
        $_SESSION['organizacion'] = $organizaciones[$_POST['editar']];
        header('Location: editarOrganizaciones.php');
        exit();
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
            <main id="menuTabla">
                <h1>Organizaciones</h1>
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
                        <th>Nombre fiscal</th>
                        <th>NIF</th>
                        <th>Persona de contacto</th>
                        <th>Teléfono de contacto</th>
                        <th>Correo de contacto</th>
                        <th>Usuarios activos</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        <form method="post">
                        <?php

                        if (count($organizaciones) == 0) {
                            echo "<tr><td colspan='9'>No se encontraron resultados</td></tr>";
                        } else {
                        foreach ($organizaciones as $key => $o) {
                            echo "<tr>";
                            echo "<td>".htmlentities($o['id'])."</td>";
                            echo "<td>".htmlentities($o['nombre'])."</td>";
                            echo "<td>".htmlentities($o['nombrefiscal'])."</td>";
                            echo "<td>".htmlentities($o['nif'])."</td>";
                            echo "<td>".htmlentities($o['nombreusuario'] ?? "---")."</td>";
                            echo "<td>".htmlentities($o['telefono'] ?? "---")."</td>";
                            echo "<td>".htmlentities($o['correo'] ?? "---")."</td>";
                            echo "<td>".htmlentities($o['usuarios_activos'] ?? "---")."</td>";
                            echo "<td><button id='editar' name='editar' value='".$key."'>Editar</button></td>";
                            echo "</tr>";
                        }
                    }
                        ?>
                        </form>
                    </tbody>
                </table>
            </main>
        </aside>
    </div>

</body>
</html>