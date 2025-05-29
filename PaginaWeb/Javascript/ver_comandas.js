fetch('/Controlador/ver_comandas.php')
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('comandas-container');

        if (!Array.isArray(data) || data.length === 0) {
            container.innerHTML = '<p>No hay comandas registradas.</p>';
            return;
        }

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
