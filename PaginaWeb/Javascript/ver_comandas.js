/**
 * Script para mostrar todas las comandas en la vista del administrador.
 * Hace una petición al backend para obtener las comandas y las muestra en pantalla.
 * Si no hay comandas, muestra un mensaje. Si hay error, muestra mensaje de error.
 */

fetch('/Controlador/ver_comandas.php')
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('comandas-container');

        // Si no hay comandas, muestra un mensaje
        if (!Array.isArray(data) || data.length === 0) {
            container.innerHTML = '<p>No hay comandas registradas.</p>';
            return;
        }

        // Por cada comanda, crea un div con la info y la lista de platos
        data.forEach(comanda => {
            const div = document.createElement('div');
            div.classList.add('comanda');
            div.innerHTML = `
        <h3>Comanda #${comanda.id_comanda}</h3>
        <p><strong>Cliente:</strong> ${comanda.email}</p>
        <p><strong>Fecha:</strong> ${comanda.fecha}</p>
        <ul>
          ${comanda.platos.map(p => `<li class="plato">${p.nombre_plato} - Cantidad: ${p.cantidad}</li>`).join('')}
        </ul>
      `;
            container.appendChild(div);
        });
    })
    .catch(error => {
        console.error('Error al cargar comandas:', error);
        document.getElementById('comandas-container').innerHTML = '<p>Error al cargar las comandas.</p>';
    });
