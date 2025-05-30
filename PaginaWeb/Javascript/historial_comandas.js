/**
 * Carga el historial de comandas finalizadas y las muestra en pantalla.
 * Hace una petición al backend para obtener las comandas con estado "listas".
 * Si no hay comandas, muestra un mensaje. Si hay error, muestra mensaje de error.
 *
 * @function cargarHistorial
 */
function cargarHistorial() {
  fetch('/Controlador/ver_comandas_listas.php')
    .then(res => res.json())
    .then(data => {
      const historialContainer = document.getElementById('historial-container');

      // Verifica si la respuesta fue exitosa y si hay comandas finalizadas
      if (!data.success || !Array.isArray(data.comandas) || data.comandas.length === 0) {
        historialContainer.innerHTML = '<p>No hay comandas finalizadas.</p>';
        return;
      }

      // Mostrar cada comanda finalizada
      data.comandas.forEach(comanda => {
        const div = document.createElement('div');
        div.classList.add('comanda', 'comandas-container');
        div.innerHTML = `
      <h3>Comanda #${comanda.id_comanda}</h3>
      <p><strong>Cliente:</strong> ${comanda.email}</p>
      <p><strong>Fecha:</strong> ${comanda.fecha}</p>
      <p><strong>Estado:</strong> ${comanda.estado}</p>
      <ul>
        ${comanda.platos.map(p => `<li>${p.nombre_plato} - Cantidad: ${p.cantidad}</li>`).join('')}
      </ul>
    `;
        historialContainer.appendChild(div);
      });
    })

    .catch(error => {
      console.error('Error al cargar historial:', error);
      document.getElementById('historial-container').innerHTML = '<p>Error al cargar el historial.</p>';
    });
}

/**
 * Cuando el DOM esté listo, carga el historial de comandas.
 *
 * @event DOMContentLoaded
 */
document.addEventListener("DOMContentLoaded", cargarHistorial);
