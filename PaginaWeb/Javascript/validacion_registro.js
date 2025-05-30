/**
 * Script para validar el formulario de registro en el frontend.
 * Verifica que todos los campos estén completos, que el email tenga formato válido
 * y que la contraseña tenga al menos 6 caracteres.
 *
 * @event DOMContentLoaded
 */
document.addEventListener("DOMContentLoaded", () => {
  // Si hay error de registro en la URL, muestra alerta y limpia la URL
  const params = new URLSearchParams(window.location.search);
  if (params.get("error") === "registro") {
    alert("Error: No se pudo registrar el usuario. Puede que ya exista.");
    window.history.replaceState({}, document.title, window.location.pathname);
  }

  const formulario = document.querySelector("form");

  formulario.addEventListener("submit", (e) => {
    const email = document.getElementById("email").value.trim();
    const nombre = document.getElementById("nombre").value.trim();
    const apellidos = document.getElementById("apellidos").value.trim();
    const direccion = document.getElementById("direccion").value.trim();
    const clave = document.getElementById("clave").value.trim();

    // Verifica que todos los campos estén completos
    if (!email || !nombre || !apellidos || !direccion || !clave) {
      alert("Todos los campos son obligatorios.");
      e.preventDefault();
      return;
    }

    // Verifica que el email tenga formato válido
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      alert("Introduce un correo electrónico válido.");
      e.preventDefault();
      return;
    }

    // Verifica que la contraseña tenga al menos 6 caracteres
    if (clave.length < 6) {
      alert("La contraseña debe tener al menos 6 caracteres.");
      e.preventDefault();
      return;
    }
  });
});