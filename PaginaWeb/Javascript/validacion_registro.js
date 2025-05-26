document.addEventListener("DOMContentLoaded", () => {
  const formulario = document.querySelector("form");

  formulario.addEventListener("submit", (e) => {
    const email = document.getElementById("email").value.trim();
    const nombre = document.getElementById("nombre").value.trim();
    const apellidos = document.getElementById("apellidos").value.trim();
    const direccion = document.getElementById("direccion").value.trim();
    const clave = document.getElementById("clave").value.trim();

    if (!email || !nombre || !apellidos || !direccion || !clave) {
      alert("Todos los campos son obligatorios.");
      e.preventDefault();
      return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      alert("Introduce un correo electrónico válido.");
      e.preventDefault();
      return;
    }

    if (clave.length < 6) {
      alert("La contraseña debe tener al menos 6 caracteres.");
      e.preventDefault();
      return;
    }
  });
});