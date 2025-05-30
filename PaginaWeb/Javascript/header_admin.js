/**
 * Cuando el DOM esté listo, inserta el header y verifica la sesión del usuario.
 * @event DOMContentLoaded
 * @description Este evento se dispara cuando el documento HTML ha sido completamente cargado y analizado,
 */
document.addEventListener("DOMContentLoaded", function () {
    const headerHTML = `
        <header>
            <img src="../img/logo_SP.png" alt="Logo Sabores Peruanos" class="logo">
            <nav id="menu-nav">
                <a href="/Vista/comandas_admin.html">Comandas</a>
                <a href="/Vista/administrador.html">Menú</a>
            </nav>
        </header>
    `;
    // Inserta el HTML del header en el contenedor con id "header-container"
    document.getElementById("header-container").innerHTML = headerHTML;
    verificarSesion();
});

/**
 * Verifica si el usuario está logueado y actualiza el menú del header.
 * Si está logueado, muestra el nombre y la opción de cerrar sesión.
 * Si no, muestra el botón para iniciar sesión.
 *
 * @function verificarSesion
 * @description Realiza una petición al servidor para verificar el estado de la sesión del usuario.
 * @returns {void}
 */
function verificarSesion() {
    // Realiza una petición al servidor para verificar si el usuario está logueado
    fetch("/Controlador/verificar_sesion.php")
        .then((response) => response.json())
        .then((data) => {
            const nav = document.querySelector("#menu-nav");
            if (!nav) return;

            if (data.logueado) {
                // Si el usuario está logueado, muestra su nombre y el botón para cerrar sesión
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
                // Añade el div del perfil al menú de navegación
                nav.appendChild(perfilDiv);
            } else {
                // Si no está logueado, muestra el enlace para iniciar sesión
                const login = document.createElement("a");
                login.href = "/Vista/login.html";
                login.textContent = "Login";
                nav.appendChild(login);
            }
        })
        .catch((error) => console.error("Error al verificar sesión:", error));
}
