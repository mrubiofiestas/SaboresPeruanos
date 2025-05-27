fetch('/Controlador/verificar_sesion.php')
    .then(res => res.json())
    .then(data => {
        const contenedorMenu = document.getElementById('menu-container');

        fetch('/Controlador/controlador_platos.php')
            .then(res => res.json())
            .then(platos => {
                platos.forEach(plato => {
                    const div = document.createElement('div');
                    div.className = 'plato';

                    const ingredientesDiv = document.createElement('div');
                    ingredientesDiv.className = 'ingredientes';
                    ingredientesDiv.style.display = 'none';

                    div.innerHTML = `
                        <div class="menu-item">
                            <div class="item-info">
                                <h3>${plato.nombre_plato}</h3>
                                <p>Precio: S/.${plato.precio}</p>
                            </div>
                            ${data.logueado && data.rol === 'Usuario'
                            ? `<button class="btn-agregar" data-nombre="${plato.nombre_plato}" data-precio="${plato.precio}">Agregar al carrito</button>`
                            : ''
                        }
                            <button class="btn-ingredientes" data-nombre="${plato.nombre_plato}">Ingredientes</button>
                        </div>
                    `;

                    const btnIngredientes = div.querySelector('.btn-ingredientes');
                    btnIngredientes.addEventListener('click', () => {
                        if (ingredientesDiv.style.display === 'none') {
                            fetch(`/Controlador/ingredientes.php?nombre_plato=${encodeURIComponent(plato.nombre_plato)}`)
                                .then(resp => resp.json())
                                .then(ingredientes => {
                                    ingredientesDiv.innerHTML = `
                                        <strong>Ingredientes:</strong>
                                        <ul>${ingredientes.map(ing => `<li>${ing}</li>`).join('')}</ul>
                                    `;
                                    ingredientesDiv.style.display = 'block';
                                });
                        } else {
                            ingredientesDiv.style.display = 'none';
                        }
                    });

                    div.appendChild(ingredientesDiv);
                    contenedorMenu.appendChild(div);
                });
            });
    });
