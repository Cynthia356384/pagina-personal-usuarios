<?php
require "conexion.php";
if (!isset($_SESSION["idcliente"]) || $_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php"); exit;
}

$id = (int)($_POST["id"] ?? 0);
$stmt = $conn->prepare("DELETE FROM clientes WHERE idcliente = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

if ($id === (int)$_SESSION["idcliente"]) {   // si se borró a sí mismo, cerrar sesión
    session_destroy();
    header("Location: login.php"); exit;
}
header("Location: panel.php?msg=" . urlencode("Usuario eliminado."));