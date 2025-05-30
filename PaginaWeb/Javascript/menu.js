/**
 * Cuando el DOM esté listo, carga el menú de platos y muestra los botones de acción.
 * Si el usuario está logueado y es de tipo Usuario, puede agregar platos al carrito.
 * También permite ver los ingredientes de cada plato.
 *
 * @event DOMContentLoaded
 */
document.addEventListener("DOMContentLoaded", () => {
    fetch('/Controlador/verificar_sesion.php')
        .then(res => res.json())
        .then(data => {
            const contenedorMenu = document.getElementById('menu-container');

            // Crea la tabla del menú
            const tabla = document.createElement('table');
            tabla.className = 'tabla-menu';
            tabla.innerHTML = `
        <thead>
          <tr>
            <th>Plato</th>
            <th>Precio</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="tbody-menu"></tbody>
      `;
            contenedorMenu.appendChild(tabla);
            const cuerpoTabla = tabla.querySelector('#tbody-menu');

            // Obtiene los platos desde el backend
            fetch('/Controlador/controlador_platos.php')
                .then(res => res.json())
                .then(platos => {
                    platos.forEach(plato => {
                        const tr = document.createElement('tr');

                        // Celda con el nombre del plato
                        const tdNombre = document.createElement('td');
                        tdNombre.textContent = plato.nombre_plato;

                        // Celda con el precio del plato
                        const tdPrecio = document.createElement('td');
                        tdPrecio.textContent = `${plato.precio}€`;

                        // Celda con los botones de acción
                        const tdAcciones = document.createElement('td');

                        // Botón para ver ingredientes
                        const btnIngredientes = document.createElement('button');
                        btnIngredientes.textContent = 'Ingredientes';
                        btnIngredientes.className = 'btn-ingredientes';

                        // Contenedor para los ingredientes (se muestra/oculta)
                        const ingredientesDiv = document.createElement('div');
                        ingredientesDiv.className = 'ingredientes';
                        ingredientesDiv.style.display = 'none';

                        btnIngredientes.addEventListener('click', () => {
                            if (ingredientesDiv.style.display === 'none') {
                                fetch(`/Controlador/ingredientes.php?nombre_plato=${encodeURIComponent(plato.nombre_plato)}`)
                                    .then(resp => resp.json())
                                    .then(ingredientes => {
                                        // Si hay ingredientes, los muestra en una lista
                                        if (Array.isArray(ingredientes)) {
                                            ingredientesDiv.innerHTML = `
      <strong>Ingredientes:</strong>
      <ul>${ingredientes.map(ing => `<li>${ing}</li>`).join('')}</ul>
    `;
                                        } else {
                                            ingredientesDiv.innerHTML = `
      <strong>No se encontraron ingredientes para este plato.</strong>
    `;
                                        }
                                        ingredientesDiv.style.display = 'block';
                                    });
                            } else {
                                ingredientesDiv.style.display = 'none';
                            }
                        });

                        tdAcciones.appendChild(btnIngredientes);

                        // Botón para agregar al carrito (solo si el usuario está logueado y es Usuario)
                        if (data.logueado && data.rol === 'Usuario') {
                            const btnAgregar = document.createElement('button');
                            btnAgregar.textContent = 'Agregar al carrito';
                            btnAgregar.className = 'btn-agregar';

                            btnAgregar.addEventListener('click', () => {
                                const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
                                carrito.push({
                                    nombre: plato.nombre_plato,
                                    precio: parseFloat(plato.precio)
                                });
                                localStorage.setItem('carrito', JSON.stringify(carrito));
                                alert(`${plato.nombre_plato} agregado al carrito`);
                            });

                            tdAcciones.appendChild(btnAgregar);
                        }

                        tr.appendChild(tdNombre);
                        tr.appendChild(tdPrecio);
                        tr.appendChild(tdAcciones);
                        cuerpoTabla.appendChild(tr);

                        // Fila extra para mostrar los ingredientes debajo del plato
                        const filaIngredientes = document.createElement('tr');
                        const celdaIngredientes = document.createElement('td');
                        celdaIngredientes.colSpan = 3;
                        celdaIngredientes.appendChild(ingredientesDiv);
                        filaIngredientes.appendChild(celdaIngredientes);
                        cuerpoTabla.appendChild(filaIngredientes);
                    });
                });
        });
});
