document.addEventListener('DOMContentLoaded', () => {
  let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
  const contenedor = document.getElementById('carrito-container');
  const totalSpan = document.getElementById('total');

  function renderCarrito() {
    contenedor.innerHTML = '';
    let total = 0;

    carrito.forEach((item, index) => {
      const div = document.createElement('div');
      div.innerHTML = `
        ${item.nombre} - € ${item.precio.toFixed(2)} x ${item.cantidad || 1}
        <button data-index="${index}" class="eliminar-btn">Eliminar</button>
      `;
      contenedor.appendChild(div);
      total += item.precio * (item.cantidad || 1);
    });

    totalSpan.innerText = total.toFixed(2);

    // Agregar eventos a los botones de eliminar
    document.querySelectorAll('.eliminar-btn').forEach(btn => {
      btn.addEventListener('click', e => {
        const index = e.target.dataset.index;
        carrito.splice(index, 1); // eliminar del array
        localStorage.setItem('carrito', JSON.stringify(carrito)); // guardar
        renderCarrito(); // volver a dibujar
      });
    });
  }

  renderCarrito(); // Mostrar al cargar

  document.getElementById('btn-pagar').addEventListener('click', () => {
    if (carrito.length === 0) {
      alert('El carrito está vacío');
      return;
    }

    fetch('/Controlador/procesar_pedido.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(carrito)
    })
      .then(res => res.json())
      .then(response => {
        if (response.success) {
          alert('¡Pedido realizado con éxito!');
          localStorage.removeItem('carrito');
          window.location.href = '/Vista/menu.html';
        } else {
          alert('Error al registrar el pedido: ' + (response.error || 'Error desconocido'));
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Hubo un problema al procesar el pedido.');
      });
  });
});
