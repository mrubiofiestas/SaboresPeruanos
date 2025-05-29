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
    document.getElementById("header-container").innerHTML = headerHTML;
    verificarSesion();
});

function verificarSesion() {
    fetch("/Controlador/verificar_sesion.php")
        .then((response) => response.json())
        .then((data) => {
            const nav = document.querySelector("#menu-nav");
            if (!nav) return;

            if (data.logueado) {
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
