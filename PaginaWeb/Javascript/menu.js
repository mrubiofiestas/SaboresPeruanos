document.addEventListener("DOMContentLoaded", () => {
    fetch("../Controlador/controlador_platos.php")
        .then((response) => response.json())
        .then((platos) => {
            const contenedor = document.getElementById("menu");
            platos.forEach((plato) => {
                const card = document.createElement("div");
                card.classList.add("plato-card");
                card.innerHTML = `
                <div id="platos-enteros">
                <h3>${plato.nombre_plato}</h3>
                    <section class="elementos">
                        <p>${plato.precio}€</p>
                        <button id="agregar-carrito" class="btn btn-primary" data-nombre="${plato.nombre_plato}" data-precio="${plato.precio}">Agregar al carrito</button>
                    </section>
                </div>       
                `;
                contenedor.appendChild(card);
            });
            document.querySelectorAll("#agregar-carrito").forEach((btn) => {
                btn.addEventListener("click", () => {
                    const nombre = btn.dataset.nombre;
                    const precio = parseFloat(btn.dataset.precio);

                    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
                    carrito.push({ nombre, precio });
                    localStorage.setItem("carrito", JSON.stringify(carrito));
                    alert(`${nombre} agregado al carrito`);
                });
            });
        });
});
