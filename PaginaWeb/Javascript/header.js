// Este script se encarga de cargar el header en las páginas y verificar la sesión del usuario
document.addEventListener("DOMContentLoaded", function () {
  const headerHTML = `
        <header>
            <img src="../img/logo_SP.png" alt="Logo Sabores Peruanos" class="logo">
            <nav id="menu-nav">
                <a href="/index.html">Inicio</a>
                <a href="/Vista/galeria.html">Galería</a>
                <a href="/Vista/menu.html">Menú</a>
                <a href="/Vista/contacto.html">Contacto</a>
            </nav>
        </header>
    `;
  // Inserta el HTML del header en el contenedor con id "header-container"
  document.getElementById("header-container").innerHTML = headerHTML;
  // Llama a la función para verificar la sesión del usuario
  verificarSesion();
});

/**
 * Verifica si el usuario está logueado y actualiza el menú del header.
 * Si está logueado, muestra el carrito y el nombre del usuario con la opción de cerrar sesión.
 * Si no, muestra el botón para iniciar sesión.
 *
 * @function verificarSesion
 * @description Realiza una petición al servidor para verificar el estado de la sesión del usuario.
 * @returns {void}
 */
function verificarSesion() {
  fetch("/Controlador/verificar_sesion.php")
    // Realiza una petición al servidor para verificar si el usuario está logueado
    .then((response) => response.json())
    .then((data) => {
      const nav = document.querySelector("#menu-nav");
      if (!nav) return;

      if (data.logueado) {
        const carrito = document.createElement("a");
        carrito.href = "../Vista/carrito.html";
        carrito.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-fill" viewBox="0 0 16 16">
  <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
</svg>`;
        nav.appendChild(carrito);
        const perfilDiv = document.createElement("div");
        perfilDiv.classList.add("perfil-usuario");
        perfilDiv.innerHTML = `
<div class="btn-group">
  <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
${data.nombre}
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="/Controlador/controlador_logout.php">Cerrar Sesión</a></li>
  </ul>
</div> `;
        nav.appendChild(perfilDiv);
      } else {
        const login = document.createElement("a");
        login.href = "/Vista/login.html";
        login.textContent = "Login";
        nav.appendChild(login);
      }
    })
    .catch((error) => console.error("Error al verificar sesión:", error));
}
