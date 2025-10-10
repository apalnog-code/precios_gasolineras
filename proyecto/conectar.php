<?php

session_name("linditec");
session_start();

try {

    $db = new PDO('mysql:host=localhost;dbname=proyecto;charset=utf8', 'root', '');
    
} catch (PDOException $e) {
    
    echo "Error de conexión a la base de datos: " . $e->getMessage();
    exit();

}