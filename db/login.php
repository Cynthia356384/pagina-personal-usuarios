<?php
require "conexion.php";
if (isset($_SESSION["idcliente"])) { header("Location: ../index/index.html"); exit; }

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"] ?? "");
    $pass    = $_POST["password"] ?? "";

    $stmt = $conn->prepare("SELECT idcliente, nombre, contrasena FROM clientes WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($u = $res->fetch_assoc()) {
        if (password_verify($pass, $u["contrasena"])) {
            $_SESSION["idcliente"] = $u["idcliente"];
            $_SESSION["nombre"] = $u["nombre"];
            header("Location: ../index/index.html");
            exit;
        }
    }
    $error = "Usuario o contraseña incorrectos.";
}

$titulo = "Iniciar sesión";
include "cabecera.php";
?>

<div class="modulo-usuarios">
    <?php if ($error): ?>
      <div class="mensaje error"><?= htmlspecialchars($error) ?> <a href="registro.php">Regístrate</a></div>
    <?php endif; ?>
    <form method="post">
      <label>Usuario</label>
      <input type="text" name="usuario" required>
      <label>Contraseña</label>
      <input type="password" name="password" required>
      <button type="submit">Entrar</button>
    </form>
    <p>¿Aún no tienes cuenta? <a href="registro.php">Regístrate</a></p>
</div>

<?php include "pie.php"; ?>