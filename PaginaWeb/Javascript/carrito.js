document.addEventListener("DOMContentLoaded", () => {
  const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
  const contenedor = document.getElementById("carrito-container");
  const totalSpan = document.getElementById("total");

  let total = 0;

  carrito.forEach(item => {
    const div = document.createElement("div");
    div.innerText = `${item.nombre} - € ${item.precio.toFixed(2)}`;
    contenedor.appendChild(div);
    total += item.precio;
  });

  totalSpan.innerText = total.toFixed(2);

  document.getElementById("btn-pagar").addEventListener("click", () => {
    fetch("/Controlador/crear_pedido.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(carrito)
    })
      .then(res => res.text())
      .then(msg => {
        alert(msg);
        localStorage.removeItem("carrito");
        window.location.href = "menu.html";
      });
  });
});
