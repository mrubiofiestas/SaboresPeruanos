document.addEventListener("DOMContentLoaded", () => {
    fetch('/Controlador/verificar_sesion.php')
        .then(res => res.json())
        .then(data => {
            const contenedorMenu = document.getElementById('menu-container');

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

            fetch('/Controlador/controlador_platos.php')
                .then(res => res.json())
                .then(platos => {
                    platos.forEach(plato => {
                        const tr = document.createElement('tr');

                        const tdNombre = document.createElement('td');
                        tdNombre.textContent = plato.nombre_plato;

                        const tdPrecio = document.createElement('td');
                        tdPrecio.textContent = `${plato.precio}€`;

                        const tdAcciones = document.createElement('td');

                        // Botón Ingredientes
                        const btnIngredientes = document.createElement('button');
                        btnIngredientes.textContent = 'Ingredientes';
                        btnIngredientes.className = 'btn-ingredientes';

                        // Contenedor para los ingredientes
                        const ingredientesDiv = document.createElement('div');
                        ingredientesDiv.className = 'ingredientes';
                        ingredientesDiv.style.display = 'none';

                        btnIngredientes.addEventListener('click', () => {
                            if (ingredientesDiv.style.display === 'none') {
                                fetch(`/Controlador/ingredientes.php?nombre_plato=${encodeURIComponent(plato.nombre_plato)}`)
                                    .then(resp => resp.json())
                                    .then(ingredientes => {
                                        console.log("Ingredientes recibidos:", ingredientes);

                                        // Verificar que ingredientes sea un array
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

                        // Botón Agregar al carrito (solo usuarios logueados)
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

                        // Fila para mostrar ingredientes
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
