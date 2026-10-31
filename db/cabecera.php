<?php
// Antes de incluirla define: $titulo = "Texto"; y, si hay formulario con validación, $usaValidacion = true;
$titulo = $titulo ?? "Mi página web";
$usaValidacion = $usaValidacion ?? false;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($titulo) ?></title>
    <meta name="author" content="Cynthia Alessandra Aguilar Uicab">
    <link rel="stylesheet" href="../css/estilos.css">
    <script type="text/javascript" src="../js/codigo.js"></script>
    <?php if ($usaValidacion): ?>
    <script src="../js/validar_usuario.js"></script>
    <?php endif; ?>
</head>

<body>

<header>
    <h1><em><?= htmlspecialchars($titulo) ?></em></h1>
</header>

<section>