/**
 * Script para mostrar todas las comandas en la vista del administrador.
 * Hace una petición al backend para obtener las comandas y las muestra en pantalla.
 * Si no hay comandas, muestra un mensaje. Si hay error, muestra mensaje de error.
 */

fetch('/Controlador/ver_comandas.php')
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('comandas-container');

        // Validamos la propiedad success y que comandas sea un array
        if (!data.success || !Array.isArray(data.comandas) || data.comandas.length === 0) {
            container.innerHTML = '<p>No hay comandas pendientes.</p>';
            return;
        }

        data.comandas.forEach(comanda => {
            const div = document.createElement('div');
            div.classList.add('comanda');
            div.innerHTML = `
            <h3>Comanda #${comanda.id_comanda}</h3>
            <p><strong>Cliente:</strong> ${comanda.email}</p>
            <p><strong>Fecha:</strong> ${comanda.fecha}</p>
            <ul>
                ${comanda.platos.map(p => `<li class="plato">${p.nombre_plato} - Cantidad: ${p.cantidad}</li>`).join('')}
            </ul>
            <button onclick="marcarComoLista(${comanda.id_comanda})">Marcar como lista</button>
        `;
            container.appendChild(div);
        });
    })

    .catch(error => {
        console.error('Error al cargar comandas:', error);
        document.getElementById('comandas-container').innerHTML = '<p>Error al cargar las comandas.</p>';
    });

function marcarComoLista(idComanda) {
    if (!confirm("¿Marcar esta comanda como lista?")) return;

    fetch('/Controlador/comanda_lista.php', {
        method: 'POST',
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=${idComanda}`
    })
        .then(res => res.json())
        .then(data => {
            if (data.exito) {
                alert("Comanda marcada como lista.");
                location.reload();
            } else {
                alert("Error al actualizar la comanda.");
            }
        })
        .catch(error => {
            console.error("Error en la petición:", error);
            alert("Error al comunicar con el servidor.");
        });
}
