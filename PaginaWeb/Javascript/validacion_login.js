/**
 * Script para validar el formulario de login en el frontend.
 * Verifica que los campos no estén vacíos y que el email tenga formato válido.
 *
 * @event DOMContentLoaded
 */
document.addEventListener("DOMContentLoaded", () => {
  // Mostrar alerta si viene un error
  const params = new URLSearchParams(window.location.search);
  const error = params.get("error");

  if (error === "credenciales") {
    alert("Error: El correo o la contraseña son incorrectos.");
  } else if (error === "incompleto") {
    alert("Por favor, completa todos los campos.");
  } else if (error === "no_autorizado") {
    alert("Acceso no autorizado.");
  }

  // Limpiar los parámetros para que no se repita el mensaje al recargar
  if (error) {
    window.history.replaceState({}, document.title, window.location.pathname);
  }

  const formulario = document.querySelector("form");

  formulario.addEventListener("submit", (e) => {
    const email = document.getElementById("email").value.trim();
    const clave = document.getElementById("clave").value.trim();

    // Verifica que ambos campos estén completos
    if (!email || !clave) {
      alert("Por favor, completa todos los campos.");
      e.preventDefault();
      return;
    }

    // Verifica que el email tenga un formato válido
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      alert("Correo electrónico no válido.");
      e.preventDefault();
      return;
    }
  });
});