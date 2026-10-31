<?php
require "conexion.php";
if (!isset($_SESSION["idcliente"])) { header("Location: login.php"); exit; }

$clientes = $conn->query("SELECT idcliente, nombre, apellido, ciudad, sexo, preferencias, usuario, fecha_registro FROM clientes ORDER BY idcliente");
$msg = $_GET["msg"] ?? "";

$titulo = "Bienvenido, " . $_SESSION["nombre"];
include "cabecera.php";
?>

<div class="modulo-usuarios ancho">

    <?php if ($msg): ?>
      <div class="mensaje ok"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <h2><em>Usuarios registrados</em></h2>
    <div class="tabla-scroll">
    <table class="tabla-usuarios">
      <tr>
        <th>ID</th><th>Nombre</th><th>Apellido</th><th>Ciudad</th>
        <th>Sexo</th><th>Preferencias</th><th>Usuario</th><th>Registro</th><th>Acciones</th>
      </tr>
      <?php while ($c = $clientes->fetch_assoc()): ?>
      <tr>
        <td><?= $c["idcliente"] ?></td>
        <td><?= htmlspecialchars($c["nombre"]) ?></td>
        <td><?= htmlspecialchars($c["apellido"]) ?></td>
        <td><?= htmlspecialchars($c["ciudad"]) ?></td>
        <td><?= htmlspecialchars($c["sexo"]) ?></td>
        <td><?= htmlspecialchars($c["preferencias"] ?? "") ?></td>
        <td><?= htmlspecialchars($c["usuario"]) ?></td>
        <td><?= $c["fecha_registro"] ?></td>
        <td class="acciones">
          <a class="btn" href="editar.php?id=<?= $c["idcliente"] ?>">Modificar</a>
          <form method="post" action="eliminar.php" onsubmit="return confirm('¿Eliminar a este usuario?');">
            <input type="hidden" name="id" value="<?= $c["idcliente"] ?>">
            <button type="submit" class="btn peligro">Eliminar</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
    </div>
</div>

<?php include "pie.php"; ?>