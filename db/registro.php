<?php
require "conexion.php";
$mensaje = ""; $tipo = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre   = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $sexo     = $_POST["sexo"] ?? "";
    $ciudad   = $_POST["ciudad"] ?? "";
    $prefs    = isset($_POST["preferencias"]) ? implode(", ", $_POST["preferencias"]) : "";
    $usuario  = trim($_POST["usuario"] ?? "");
    $pass     = $_POST["password"] ?? "";
    $pass2    = $_POST["password2"] ?? "";

    if ($nombre === "" || $apellido === "" || $ciudad === "" || !in_array($sexo, ["M", "F"])
        || strlen($usuario) < 3 || strlen($usuario) > 20 || strlen($pass) < 6 || $pass !== $pass2) {
        $mensaje = "Datos inválidos. Revisa el formulario."; $tipo = "error";
    } else {
        $stmt = $conn->prepare("SELECT idcliente FROM clientes WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $mensaje = "Ese usuario ya existe."; $tipo = "error";
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $ins = $conn->prepare("INSERT INTO clientes (nombre, apellido, ciudad, sexo, preferencias, usuario, contrasena) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $ins->bind_param("sssssss", $nombre, $apellido, $ciudad, $sexo, $prefs, $usuario, $hash);
            if ($ins->execute()) {
                $mensaje = "Registro exitoso. Ya puedes iniciar sesión."; $tipo = "ok";
            } else {
                $mensaje = "No se pudo registrar el usuario."; $tipo = "error";
            }
        }
    }
}

$titulo = "Registro de usuarios";
$usaValidacion = true;
include "cabecera.php";
?>

<div class="modulo-usuarios">
    <div id="errores" class="mensaje error" style="display:none"></div>
    <?php if ($mensaje): ?>
      <div class="mensaje <?= $tipo ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form method="post" data-validar novalidate>
      <label>Nombre</label>
      <input type="text" name="nombre">

      <label>Apellido</label>
      <input type="text" name="apellido">

      <label>Sexo</label>
      <div>
        <label><input type="radio" name="sexo" value="M"> Masculino</label>
        <label><input type="radio" name="sexo" value="F"> Femenino</label>
      </div>

      <label>Preferencias</label>
      <div>
        <label><input type="checkbox" name="preferencias[]" value="Música"> Música</label>
        <label><input type="checkbox" name="preferencias[]" value="Deportes"> Deportes</label>
        <label><input type="checkbox" name="preferencias[]" value="Internet"> Internet</label>
        <label><input type="checkbox" name="preferencias[]" value="Baile"> Baile</label>
      </div>

      <label>Ciudad</label>
      <select name="ciudad">
        <option value="">-- Elige una ciudad --</option>
        <option>Mérida</option>
        <option>Valladolid</option>
        <option>Tizimín</option>
        <option>Progreso</option>
        <option>Otra</option>
      </select>

      <label>Usuario (de 3 a 20 caracteres)</label>
      <input type="text" name="usuario" maxlength="20">

      <label>Contraseña (mínimo 6 caracteres)</label>
      <input type="password" name="password">

      <label>Repetir contraseña</label>
      <input type="password" name="password2">

      <button type="submit">Registrarme</button>
    </form>
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
</div>

<?php include "pie.php"; ?>