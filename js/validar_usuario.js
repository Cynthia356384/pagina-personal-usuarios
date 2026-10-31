document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form[data-validar]");
  if (!form) return;

  form.addEventListener("submit", (e) => {
    const errores = [];
    const campo = (n) => form.querySelector("[name='" + n + "']");

    const nombre = campo("nombre");
    const apellido = campo("apellido");
    const ciudad = campo("ciudad");
    const usuario = campo("usuario");
    const pass = campo("password");
    const pass2 = campo("password2");
    const opcional = form.hasAttribute("data-pass-opcional");

    if (nombre && nombre.value.trim() === "") errores.push("Escribe tu nombre.");
    if (apellido && apellido.value.trim() === "") errores.push("Escribe tu apellido.");
    if (form.querySelector("[name=sexo]") && !form.querySelector("[name=sexo]:checked")) {
      errores.push("Elige un sexo.");
    }
    if (ciudad && ciudad.value === "") errores.push("Elige una ciudad.");
    if (usuario && (usuario.value.trim().length < 3 || usuario.value.trim().length > 20)) {
      errores.push("El usuario debe tener entre 3 y 20 caracteres.");
    }
    if (pass && (!opcional || pass.value.length > 0)) {
      if (pass.value.length < 6) errores.push("La contraseña debe tener al menos 6 caracteres.");
      if (pass2 && pass.value !== pass2.value) errores.push("Las contraseñas no coinciden.");
    }

    const caja = document.getElementById("errores");
    if (errores.length > 0) {
      e.preventDefault();
      caja.innerHTML = errores.map((m) => "<p>" + m + "</p>").join("");
      caja.style.display = "block";
    } else if (caja) {
      caja.style.display = "none";
    }
  });
});