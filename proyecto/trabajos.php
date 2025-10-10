<?php

require_once 'conectar.php';
global $db; 

if(isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
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
                <h1>Trabajos</h1>
                <form action="" method="post">
                    <div id="organizacionesDIV">
                        <div>
                            <label for="organizaciones">Organización</label>
                            <p>
                                <select name="slctOrganizacion" id="organizaciones">
                                    <option value="">--Selecciona una organización--</option>
                                </select>
                            </p>
                        </div>    
                        <div>
                            <label for="desdeFecha">Desde</label>
                            <p>
                                <input type="date" id="desdeFecha" name="desdeFecha">
                            </p>
                        </div>
                        <div>
                            <label for="desdeHasta">Hasta</label>
                            <p>
                                <input type="date" id="desdeHasta" name="desdeHastaa">
                            </p>
                        </div>
                        <div>
                            <button type="submit" name="buscar">Buscar</button>
                        </div>
                    </div>
                </form>
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
                        <th>Tipo de trabajo</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Zona</th>
                        <th>Organización</th>
                        <th>Nº de puntos de control asignado</th>
                        <th>Fecha de inicio</th>
                        <th>Completado</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </main>
        </aside>
    </div>

</body>
</html>