<?php
require "conexion.php";
if (!isset($_SESSION["idcliente"])) { header("Location: login.php"); exit; }

$id = (int)($_GET["id"] ?? $_POST["id"] ?? 0);
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

    $valido = $nombre !== "" && $apellido !== "" && $ciudad !== ""
              && in_array($sexo, ["M", "F"])
              && strlen($usuario) >= 3 && strlen($usuario) <= 20;
    if ($pass !== "" && (strlen($pass) < 6 || $pass !== $pass2)) { $valido = false; }

    if (!$valido) {
        $mensaje = "Datos inválidos. Revisa el formulario."; $tipo = "error";
    } else {
        $chk = $conn->prepare("SELECT idcliente FROM clientes WHERE usuario = ? AND idcliente <> ?");
        $chk->bind_param("si", $usuario, $id);
        $chk->execute();
        $chk->store_result();

        if ($chk->num_rows > 0) {
            $mensaje = "Ese usuario ya lo usa otra persona."; $tipo = "error";
        } else {
            if ($pass !== "") {
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $up = $conn->prepare("UPDATE clientes SET nombre=?, apellido=?, ciudad=?, sexo=?, preferencias=?, usuario=?, contrasena=? WHERE idcliente=?");
                $up->bind_param("sssssssi", $nombre, $apellido, $ciudad, $sexo, $prefs, $usuario, $hash, $id);
            } else {
                $up = $conn->prepare("UPDATE clientes SET nombre=?, apellido=?, ciudad=?, sexo=?, preferencias=?, usuario=? WHERE idcliente=?");
                $up->bind_param("ssssssi", $nombre, $apellido, $ciudad, $sexo, $prefs, $usuario, $id);
            }
            $up->execute();
            if ($id === (int)$_SESSION["idcliente"]) { $_SESSION["nombre"] = $nombre; }
            header("Location: panel.php?msg=" . urlencode("Usuario actualizado."));
            exit;
        }
    }
}

$stmt = $conn->prepare("SELECT * FROM clientes WHERE idcliente = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$u = $stmt->get_result()->fetch_assoc();
if (!$u) { header("Location: panel.php?msg=" . urlencode("Usuario no encontrado.")); exit; }

$prefsActuales = array_map("trim", explode(",", $u["preferencias"] ?? ""));
$ciudades = ["Mérida", "Valladolid", "Tizimín", "Progreso", "Otra"];

$titulo = "Modificar usuario";
$usaValidacion = true;
include "cabecera.php";
?>

<div class="modulo-usuarios">
    <div id="errores" class="mensaje error" style="display:none"></div>
    <?php if ($mensaje): ?>
      <div class="mensaje <?= $tipo ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form method="post" data-validar data-pass-opcional novalidate>
      <input type="hidden" name="id" value="<?= $u["idcliente"] ?>">

      <label>Nombre</label>
      <input type="text" name="nombre" value="<?= htmlspecialchars($u["nombre"]) ?>">

      <label>Apellido</label>
      <input type="text" name="apellido" value="<?= htmlspecialchars($u["apellido"]) ?>">

      <label>Sexo</label>
      <div>
        <label><input type="radio" name="sexo" value="M" <?= $u["sexo"] === "M" ? "checked" : "" ?>> Masculino</label>
        <label><input type="radio" name="sexo" value="F" <?= $u["sexo"] === "F" ? "checked" : "" ?>> Femenino</label>
      </div>

      <label>Preferencias</label>
      <div>
        <?php foreach (["Música", "Deportes", "Internet", "Baile"] as $p): ?>
          <label><input type="checkbox" name="preferencias[]" value="<?= $p ?>" <?= in_array($p, $prefsActuales) ? "checked" : "" ?>> <?= $p ?></label>
        <?php endforeach; ?>
      </div>

      <label>Ciudad</label>
      <select name="ciudad">
        <option value="">-- Elige una ciudad --</option>
        <?php foreach ($ciudades as $c): ?>
          <option <?= $u["ciudad"] === $c ? "selected" : "" ?>><?= $c ?></option>
        <?php endforeach; ?>
      </select>

      <label>Usuario (de 3 a 20 caracteres)</label>
      <input type="text" name="usuario" maxlength="20" value="<?= htmlspecialchars($u["usuario"]) ?>">

      <label>Nueva contraseña (déjala vacía para no cambiarla)</label>
      <input type="password" name="password">

      <label>Repetir nueva contraseña</label>
      <input type="password" name="password2">

      <button type="submit">Guardar cambios</button>
    </form>
    <p><a href="panel.php">← Volver</a></p>
</div>

<?php include "pie.php"; ?>