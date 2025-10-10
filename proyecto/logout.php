<?php

require_once 'conectar.php';
global $db; 

session_destroy();
header("Location: login.php");