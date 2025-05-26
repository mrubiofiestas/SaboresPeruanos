document.addEventListener("DOMContentLoaded", () => {
  const formulario = document.querySelector("form");

  formulario.addEventListener("submit", (e) => {
    const email = document.getElementById("email").value.trim();
    const clave = document.getElementById("clave").value.trim();

    if (!email || !clave) {
      alert("Por favor, completa todos los campos.");
      e.preventDefault();
      return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      alert("Correo electrónico no válido.");
      e.preventDefault();
      return;
    }
  });
});