document.addEventListener("DOMContentLoaded", () => {
  fetch("/Controlador/obtener_comandas.php")
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById("comandas-body");
      data.forEach(comanda => {
        const fila = document.createElement("tr");
        fila.innerHTML = `
          <td>${comanda.cod_pedido}</td>
          <td>${comanda.nombre} ${comanda.apellidos}</td>
          <td>${comanda.email_usuario}</td>
          <td>${comanda.descripcion}</td>
        `;
        tbody.appendChild(fila);
      });
    })
    .catch(error => {
      console.error("Error cargando comandas:", error);
      alert("Hubo un problema al cargar las comandas.");
    });
});
