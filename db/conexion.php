<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "gestion_usuarios";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Error de conexión a la base de datos.");
}
$conn->set_charset("utf8mb4");
session_start();